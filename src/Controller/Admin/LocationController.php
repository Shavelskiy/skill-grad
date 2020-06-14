<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Helpers\SearchHelper;
use App\Repository\LocationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/admin/location")
 */
class LocationController extends AbstractController
{
    protected LocationRepository $locationRepository;
    protected TranslatorInterface $translator;

    public function __construct(
        LocationRepository $locationRepository,
        TranslatorInterface $translator
    ) {
        $this->locationRepository = $locationRepository;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="admin.location.index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
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

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
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
     * @Route("/all", name="admin.location.all", methods={"GET"})
     */
    public function fetchAll(): Response
    {
        $locations = [];
        /** @var Location $location */
        foreach ($this->locationRepository->findAll() as $location) {
            $path = [];
            $parentLocation = clone $location;

            while ($parentLocation !== null) {
                $path[] = $parentLocation->getName();
                $parentLocation = $parentLocation->getParentLocation();
            }

            $locations[] = [
              'value' => $location->getId(),
              'title' => implode(', ', $path),
            ];
        }

        return new JsonResponse(['locations' => $locations]);
    }
}
