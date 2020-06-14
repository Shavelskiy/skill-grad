<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Helpers\SearchHelper;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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

/**
 * @Route("/api/admin/category")
 */
class CategoryController extends AbstractController
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
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

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
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
     * @Route("/{id}", name="admin.category.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(int $id): Response
    {
        try {
            if ($id < 1) {
                throw new RuntimeException('');
            }

            /** @var Category $category */
            $category = $this->categoryRepository->find($id);

            if ($category === null) {
                throw new RuntimeException('');
            }

            return new JsonResponse([
                'id' => $category->getId(),
                'name' => $category->getName(),
                'slug' => $category->getSlug(),
                'sort' => $category->getSort(),
                'parent_category' => $this->prepareParentCateroy($category),
                'child_categories' => $this->prepareChildCategories($category),
            ]);
        } catch (Exception $e) {
            throw new NotFoundHttpException('');
        }
    }

    protected function prepareParentCateroy(Category $category): ?array
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
            /** @var Category $parentCategory */
            $parentCategory = $this->categoryRepository->find($parentCategoryId);

            if ($parentCategory === null) {
                return new JsonResponse([], 404);
            }

            $category->setParentCategory($parentCategory);
        }

        $this->getDoctrine()->getManager()->persist($category);

        try {
            $this->getDoctrine()->getManager()->flush();
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
        /** @var Category $category */
        $category = $this->categoryRepository->find($request->get('id'));

        if ($category === null) {
            return new JsonResponse([], 404);
        }

        $category
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.category.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($request->get('id'));

        if ($category === null) {
            return new JsonResponse([], 404);
        }

        $this->getDoctrine()->getManager()->remove($category);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/all", name="admin.category.all", methods={"GET"})
     */
    public function fetchAll(): Response
    {
        $categories = [];

        /** @var Category $categroy */
        foreach ($this->categoryRepository->findAll() as $categroy) {
            $categories[] = $this->prepareItem($categroy);
        }

        return new JsonResponse(['categories' => $categories]);
    }
}
