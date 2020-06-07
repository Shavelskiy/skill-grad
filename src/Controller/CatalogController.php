<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog")
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/{slug}", name="catalog.view")
     */
    public function view(Request $request): Response
    {
        return $this->render('catalog/index.html.twig', [
            'slug' => $request->get('slug')
        ]);
    }
}
