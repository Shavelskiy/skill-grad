<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    protected PageRepository $pageRepository;

    public function __construct(
        PageRepository $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("/page/{slug}", name="app.page.index", methods={"GET"})
     */
    public function index(string $slug): Response
    {
        if (($page = $this->pageRepository->findOneBy(['slug' => $slug])) === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
