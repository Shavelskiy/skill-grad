<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Helpers\SearchHelper;
use App\Repository\LocationRepository;
use App\Service\LocationService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/admin/location")
 */
class LocationController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected LocationRepository $locationRepository;
    protected TranslatorInterface $translator;
    protected LocationService $locationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LocationRepository $locationRepository,
        TranslatorInterface $translator,
        LocationService $locationService
    ) {
        $this->entityManager = $entityManager;
        $this->locationRepository = $locationRepository;
        $this->translator = $translator;
        $this->locationService = $locationService;
    }

    /**
     * @Route("/", name="admin.location.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Location::class]);

        $paginator = $this->locationRepository->getPaginatorResult($searchQuery);

        $items = [];
        foreach ($paginator->getItems() as $item) {
            $items[] = $this->prepareItem($item);
        }

        return new JsonResponse([
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ]);
    }

    protected function prepareItem(Location $location): array
    {
        return [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'code' => $location->getCode(),
            'show_in_list' => $location->isShowInList(),
            'type' => $this->translator->trans('location.type.' . $location->getType()),
            'sort' => $location->getSort(),
        ];
    }

    /**
     * @Route("/{id}", name="admin.location.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(int $id): Response
    {
        try {
            if ($id < 1) {
                throw new RuntimeException('');
            }

            $location = $this->locationRepository->find($id);

            if ($location === null) {
                throw new RuntimeException('');
            }

            $parentLocations = [];
            $parentLocation = (clone $location)->getParentLocation();

            while ($parentLocation !== null) {
                $parentLocations[] = [
                    'id' => $parentLocation->getId(),
                    'name' => $parentLocation->getName(),
                    'sort' => $parentLocation->getSort(),
                    'type' => $this->translator->trans('location.type.' . $parentLocation->getType()),
                ];

                $parentLocation = $parentLocation->getParentLocation();
            }

            $childLocations = [];
            foreach ($location->getChildLocations() as $childLocation) {
                $childLocations[] = [
                    'id' => $childLocation->getId(),
                    'name' => $childLocation->getName(),
                    'sort' => $childLocation->getSort(),
                    'type' => $this->translator->trans('location.type.' . $childLocation->getType()),
                ];
            }

            return new JsonResponse([
                'id' => $location->getId(),
                'name' => $location->getName(),
                'code' => $location->getCode(),
                'showInList' => $location->isShowInList(),
                'type' => $location->getType(),
                'typeLang' => $this->translator->trans('location.type.' . $location->getType()),
                'sort' => $location->getSort(),
                'parentLocations' => $parentLocations,
                'parentLocationId' => $location->getParentLocation() ? $location->getParentLocation()->getId() : null,
                'childLocations' => $childLocations,
            ]);
        } catch (Exception $e) {
            throw new NotFoundHttpException('');
        }
    }

    /**
     * @Route("/all", name="admin.location.all", methods={"GET"})
     */
    public function fetchAll(): Response
    {
        $locations = [];
        foreach ($this->locationRepository->findAll() as $location) {
            $locations[] = [
                'value' => $location->getId(),
                'title' => $this->locationService->getLocationPath($location),
            ];
        }

        return new JsonResponse(['locations' => $locations]);
    }

    /**
     * @Route("", name="admin.location.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $location = (new Location())
            ->setName($request->get('name'))
            ->setCode($request->get('code'))
            ->setSort($request->get('sort'))
            ->setShowInList($request->get('showInList'))
            ->setType($request->get('type'));

        $parentLocationId = (int)($request->get('parentLocation'));
        if ($parentLocationId > 0) {
            $parentLocation = $this->locationRepository->find($parentLocationId);

            if ($parentLocation === null) {
                return new JsonResponse([], 404);
            }

            $location->setParentLocation($parentLocation);
        }

        $this->entityManager->persist($location);

        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(['message' => 'Элемент с таким code уже существует'], 400);
        }

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.location.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        $location = $this->locationRepository->find($request->get('id'));

        if ($location === null) {
            return new JsonResponse([], 404);
        }

        $location
            ->setName($request->get('name'))
            ->setCode($request->get('code'))
            ->setSort($request->get('sort'))
            ->setShowInList($request->get('showInList'))
            ->setType($request->get('type'));

        $parentLocationId = (int)($request->get('parentLocation'));
        if ($parentLocationId > 0) {
            $parentLocation = $this->locationRepository->find($parentLocationId);

            if ($parentLocation === null) {
                return new JsonResponse([], 404);
            }

            $location->setParentLocation($parentLocation);
        } else {
            $location->setParentLocation(null);
        }

        $this->entityManager->persist($location);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.location.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        $location = $this->locationRepository->find($request->get('id'));

        if ($location === null) {
            return new JsonResponse([], 404);
        }

        /** @var Location $childLocation */
        foreach ($location->getChildLocations() as $childLocation) {
            $childLocation->setParentLocation(null);
            $this->entityManager->persist($childLocation);
        }

        $this->entityManager->remove($location);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
