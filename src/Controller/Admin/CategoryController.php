<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Helpers\SearchHelper;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/category")
 */
class CategoryController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("", name="admin.category.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Category::class]);

        $paginator = $this->categoryRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(Category $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'slug' => $item->getSlug(),
            'is_parent' => $item->getParentCategory() === null,
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{category}", name="admin.category.view", methods={"GET"}, requirements={"category"="[0-9]+"})
     */
    public function view(Category $category): Response
    {
        try {
            return new JsonResponse([
                'id' => $category->getId(),
                'name' => $category->getName(),
                'slug' => $category->getSlug(),
                'sort' => $category->getSort(),
                'parent_category' => $this->prepareParentCategory($category),
                'child_categories' => $this->prepareChildCategories($category),
            ]);
        } catch (Exception $e) {
            throw new NotFoundHttpException('');
        }
    }

    protected function prepareParentCategory(Category $category): ?array
    {
        if (($parentCategory = $category->getParentCategory()) === null) {
            return null;
        }

        return [
            'id' => $parentCategory->getId(),
            'name' => $parentCategory->getName(),
            'slug' => $parentCategory->getSlug(),
            'sort' => $parentCategory->getSort(),
        ];
    }

    protected function prepareChildCategories(Category $category): array
    {
        $result = [];

        /** @var Category $childCategory */
        foreach ($category->getChildCategories() as $childCategory) {
            $result[] = [
                'id' => $childCategory->getId(),
                'name' => $childCategory->getName(),
                'slug' => $category->getSlug(),
                'sort' => $childCategory->getSort(),
            ];
        }

        return $result;
    }

    /**
     * @Route("/{id}", name="admin.category.create", methods={"POST"}, requirements={"id"="[0-9]*"})
     */
    public function create(Request $request): Response
    {
        $category = (new Category())
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'));

        $parentCategoryId = (int)($request->get('id'));
        if ($parentCategoryId > 0) {
            $parentCategory = $this->categoryRepository->find($parentCategoryId);

            if ($parentCategory === null) {
                return new JsonResponse([], 404);
            }

            $category->setParentCategory($parentCategory);
        }

        $this->entityManager->persist($category);

        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(['message' => 'Элемент с таким slug уже существует'], 400);
        }

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.category.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        $category = $this->categoryRepository->find($request->get('id'));

        if ($category === null) {
            return new JsonResponse([], 404);
        }

        $category
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'));

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.category.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        $category = $this->categoryRepository->find($request->get('id'));

        if ($category === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/all", name="admin.category.all", methods={"GET"})
     */
    public function fetchAll(): Response
    {
        $categories = [];

        foreach ($this->categoryRepository->findAll() as $category) {
            $categories[] = $this->prepareItem($category);
        }

        return new JsonResponse(['categories' => $categories]);
    }
}
