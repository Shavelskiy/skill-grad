<?php

namespace App\Controller\Admin;

use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractCrudController extends AdminAbstractController implements CrudControllerInterface
{
    /**
     * @param null $model
     *
     * @return FormInterface
     */
    abstract protected function getForm($model = null): FormInterface;

    abstract protected function getModelClass();

    /**
     * {@inheritdoc}
     */
    protected function findModel($id)
    {
        if (($user = $this->getRepository()->find($id)) === null) {
            throw new NotFoundHttpException('model not found');
        }

        return $user;
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository($this->getModelClass());
    }
}
