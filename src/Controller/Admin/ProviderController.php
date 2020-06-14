<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Provider;
use App\Helpers\SearchHelper;
use App\Repository\CategoryRepository;
use App\Repository\ProviderRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/provider")
 */
class ProviderController extends AbstractController
{
    protected CategoryRepository $categoryRepository;
    protected ProviderRepository $providerRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProviderRepository $providerRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->providerRepository = $providerRepository;
    }

    /**
     * @Route("", name="admin.provider.index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Article::class]);

        $paginator = $this->providerRepository->getPaginatorResult($searchQuery);

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

    public function prepareItem(Provider $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
        ];
    }

    /**
     * @Route("", name="admin.provider.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $provider = (new Provider())
                ->setName($request->get('name'))
                ->setDescription($request->get('description'))
                ->setCategoryGroups($this->categoryRepository->findBy(['id' => $request->get('mainCategories')]))
                ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]));

            $this->getDoctrine()->getManager()->persist($provider);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([]);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
