<?php

namespace App\Controller\Admin;

use Symfony\Component\Form\FormInterface;

abstract class AbstractCrudController extends AdminAbstractController implements CrudControllerInterface
{
    /**
     * @param $tag
     *
     * @return FormInterface
     */
    abstract protected function getForm($tag = null): FormInterface;

    /**
     * @param $id
     *
     * @return object|null
     */
    abstract protected function findModel($id);

    abstract protected function getRepository();
}
