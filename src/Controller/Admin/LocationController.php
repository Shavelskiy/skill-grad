<?php

namespace App\Controller\Admin;

use App\Dto\Filter\LocationFilter;
use App\Dto\PaginatorResult;
use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use RuntimeException;
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
    protected const DEFAULT_PAGE_ITEMS = 10;

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
     * @Route("/", methods={"GET"}, name="admin.location.index")
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
        $page = (int)$request->get('page', 1);
        $order = json_decode($request->get('order', ''), true);
        $search = json_decode($request->get('search', ''), true);
        $pageItemCount = (int)$request->get('pageItemCount', 0);

        if ($pageItemCount < 1) {
            $pageItemCount = self::DEFAULT_PAGE_ITEMS;
        }

        $paginator = $this->locationRepository
            ->getPaginatorLocations($page, is_array($order) ? $order : null, $pageItemCount, is_array($search) ? $search : null);

        $items = [];

        foreach ($paginator->getItems() as $item) {
            $items[] = $this->prepareLocationItem($item);
        }

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
    }

    /**
     * @param Location $location
     * @return array
     */
    protected function prepareLocationItem(Location $location): array
    {
        return [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'type' => $this->translator->trans('location.type.' . $location->getType()),
            'sort' => $location->getSort(),
        ];
    }
}
