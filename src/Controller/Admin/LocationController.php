<?php

namespace App\Controller\Admin;

use App\Dto\Filter\LocationFilter;
use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use RuntimeException;
use Exception;

/**
 * @Route("/admin/location")
 */
class LocationController extends AbstractController
{
    protected const DEFAULT_PAGE_ITEMS = 10;

    protected LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @Route("/", methods={"GET"}, name="admin.location.index")
     * @param Request $request
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $page = (int)$request->get('page', 1);
        $filter = LocationFilter::createFromArray($request->get('filter', []));

        $query = $this->locationRepository->getQueryFromFilter($filter);

        $locations = (clone $query)
            ->setMaxResults(self::DEFAULT_PAGE_ITEMS)
            ->setFirstResult(($page - 1) * self::DEFAULT_PAGE_ITEMS)
            ->getQuery()
            ->getResult();

        $count = $this->locationRepository->getCountFromQuery($query);

        return $this->render('admin/location/index.html.twig', [
            'locations' => $locations,
            'filter' => $filter,
            'count' => $count,
            'page' => $page,
            'pageCount' => ceil($count / self::DEFAULT_PAGE_ITEMS),
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="admin.location.view", requirements={"id"="[0-9]+"})
     * @param Request $request
     * @return Response
     */
    public function view(Request $request): Response
    {
        $locationId = $request->get('id');

        /** @var Location $location */
        $location = $this->locationRepository->find($locationId);

        if ($location === null) {
            return $this->redirectToRoute('admin.location.index');
        }

        $parentLocations = [];
        $parentLocation = $location;
        while ($parentLocation = $parentLocation->getParentLocation()) {
            $parentLocations[] = $parentLocation;
        }

        return $this->render('admin/location/view.html.twig', [
            'location' => $location,
            'parentLocations' => $parentLocations,
        ]);
    }

    /**
     * @Route("/create", methods={"GET"}, name="admin.location.create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $location = (new Location())
            ->setSort(100);

        try {
            $parentLocation = $this->getParentLocationFromRequest($request);
            $location
                ->setParentLocation($parentLocation)
                ->setType();
        } catch (Exception $e) {
        }

    }

    protected function getParentLocationFromRequest(Request $request): Location
    {
        $parentLocationId = $request->get('parentLocation', null);

        try {
            if ($parentLocationId === null) {
                throw new RuntimeException('')
            } 

            return $this->locationRepository->findById($parentLocationId);
        } catch (Exception $e) {
            throw new RuntimeException('parent location not found in request');
        }
    }
}
