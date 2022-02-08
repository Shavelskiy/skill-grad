<?php

namespace App\Controller\Admin;

use App\Entity\Content\Seo\AbstractSeo;
use App\Repository\Content\Seo\DefaultSeoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/seo")
 */
class SeoController extends AbstractController
{
    protected EntityManagerInterface $entityManger;
    protected DefaultSeoRepository $defaultSeoRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DefaultSeoRepository $defaultSeoRepository
    ) {
        $this->entityManger = $entityManager;
        $this->defaultSeoRepository = $defaultSeoRepository;
    }

    /**
     * @Route("", name="admin.seo.index", methods={"GET"})
     */
    public function index(): Response
    {
        $data = [];

        foreach ($this->defaultSeoRepository->findAll() as $defaultSeo) {
            $data[] = [
                'id' => $defaultSeo->getId(),
                'slug' => $defaultSeo->getPageSlug(),
                'description' => $defaultSeo->getPageDescription(),
                'seo' => $this->prepareSeoData($defaultSeo),
            ];
        }

        return new JsonResponse([
            'items' => $data,
            'total_pages' => 1,
            'current_page' => 1,
        ]);
    }

    /**
     * @Route("/article", name="admin.seo-article.index", methods={"GET"})
     */
    public function articleIndex(): Response
    {
        return new JsonResponse([], 404);
    }

    /**
     * @Route("/provider", name="admin.seo-provider.index", methods={"GET"})
     */
    public function providerIndex(): Response
    {
        return new JsonResponse([], 404);
    }

    /**
     * @Route("/program", name="admin.seo-program.index", methods={"GET"})
     */
    public function programIndex(): Response
    {
        return new JsonResponse([], 404);
    }

    /**
     * @Route("/page", name="admin.seo-page.index", methods={"GET"})
     */
    public function pageIndex(): Response
    {
        return new JsonResponse([], 404);
    }

    protected function prepareSeoData(AbstractSeo $seo): array
    {
        return [
            'title' => $seo->getMetaTitle(),
            'description' => $seo->getMetaDescription(),
            'keywords' => $seo->getMetaKeywords(),
        ];
    }
}
