<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
class UserController extends AbstractCrudController
{
    protected function getModelClass()
    {
        return User::class;
    }

    /**
     * @Route("/", name="admin.user.index", methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    /**
     * @Route("/create", name="admin.user.create", methods={"GET", "HEAD"})
     */
    public function create(): Response
    {
        // TODO: Implement create() method.
    }

    /**
     * @Route("/create", name="admin.user.store", methods={"POST", "PUT"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
        // TODO: Implement store() method.
    }

    /**
     * @Route("/{id}/edit", name="admin.user.edit", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function edit($id): Response
    {
        // TODO: Implement edit() method.
    }

    /**
     * @Route("/{id}/edit", name="admin.user.update", methods={"POST", "PUT"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request): Response
    {
        // TODO: Implement update() method.
    }

    /**
     * @Route("/{id}/destroy", name="admin.user.destroy", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function destroy($id): Response
    {
        // TODO: Implement destroy() method.
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm($model = null): FormInterface
    {
        // TODO: Implement getForm() method.
    }
}
