<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tags")
 */
class TagController extends AdminAbstractController
{
    /**
     * @Route("/", name="admin.tag.index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/tag/index.html.twig');
    }

    /**
     * @Route("/{tag}", name="admin.tag.show", methods={"GET"})
     */
    public function show($id): Response
    {
        dd('show');
    }

    /**
     * @Route("/create", name="admin.tag.create", methods={"GET"})
     */
    public function create(): Response
    {
        dd('create');
    }

    /**
     * @Route("/create", name="admin.tag.store", methods={"POST"})
     */
    public function store(): Response
    {
        dd('store');
    }

    /**
     * @Route("/{tag}/edit", name="admin.tag.edit", methods={"GET"})
     */
    public function edit(): Response
    {
        dd('edit');
    }

    /**
     * @Route("/{tag}/edit", name="admin.tag.update", methods={"POST"})
     */
    public function update(): Response
    {
        dd('update');
    }

    /**
     * @Route("/{tag}", name="admin.tag.destroy", methods={"DELETE"})
     */
    public function destroy(): Response
    {
        dd('destroy');
    }
}
