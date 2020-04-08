<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface CrudControllerInterface
{
    /**
     * @return Response
     */
    public function index(): Response;

    /**
     * @return Response
     */
    public function create(): Response;

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response;

    /**
     * @param $id
     *
     * @return Response
     */
    public function edit($id): Response;

    /**
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request): Response;

    /**
     * @param $id
     *
     * @return Response
     */
    public function destroy($id): Response;
}
