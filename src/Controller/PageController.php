<?php

namespace App\Controller;

use App\Controller\Traits\SeoTrait;
use App\Repository\Content\PageRepository;
use App\Repository\Content\Seo\DefaultSeoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    protected PageRepository $pageRepository;

    use SeoTrait;

    public function __construct(
        PageRepository $pageRepository,
        DefaultSeoRepository $defaultSeoRepository
    ) {
        $this->pageRepository = $pageRepository;

        $this->setDefaultSeoRepository($defaultSeoRepository);
    }

    /**
     * @Route("/page/{slug}", name="app.page.index", methods={"GET"})
     */
    public function index(string $slug): Response
    {
        if (($page = $this->pageRepository->findOneBy(['slug' => $slug])) === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('page/index.html.twig', $this->applySeoToPage([
            'page' => $page,
        ], $page));
    }
}
