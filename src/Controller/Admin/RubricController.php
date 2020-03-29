<?php

namespace App\Controller\Admin;

use App\Entity\Rubric;
use App\Repository\RubricRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/rubric")
 */
class RubricController extends AdminAbstractController
{
    /**
     * @Route("/", name="admin.rubric.index", methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        return $this->render('admin/rubric/index.html.twig', [
            'rubrics' => $this->getRubricRepository()->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="admin.rubric.create", methods={"GET", "HEAD"})
     */
    public function create(): Response
    {
        $rubric = new Rubric();

        $maxSortRubric = $this->getRubricRepository()->getRubricWithMaxSort();
        $rubric->setSort(($maxSortRubric !== null) ? ($maxSortRubric->getSort() + 100) : 100);

        return $this->render('admin/rubric/create.html.twig', [
            'form' => $this->getForm($rubric)->createView(),
        ]);
    }

    /**
     * @Route("/create", name="admin.rubric.store", methods={"POST", "PUT"})
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $form = $this->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('admin.rubric.index');
        }

        return $this->render('admin/rubric/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.rubric.edit", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @return Response
     */
    public function edit($id): Response
    {
        $rubric = $this->findRubric($id);

        return $this->render('admin/rubric/edit.html.twig', [
            'rubric' => $rubric,
            'form' => $this->getForm($rubric)->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.rubric.update", methods={"POST", "PUT"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request): Response
    {
        $rubric = $this->findRubric($id);

        $form = $this->getForm($rubric)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('admin.rubric.index');
        }

        return $this->render('admin/rubric/edit.html.twig', [
            'rubric' => $rubric,
            'form' => $this->getForm($rubric)->createView(),
        ]);
    }

    /**
     * @Route("/{id}/destroy", name="admin.rubric.destroy", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @return Response
     */
    public function destroy($id): Response
    {
        $rubric = $this->findRubric($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($rubric);
        $em->flush();

        return $this->redirectToRoute('admin.rubric.index');
    }

    /**
     * @param null $rubric
     * @return FormInterface
     */
    protected function getForm($rubric = null): FormInterface
    {
        if ($rubric === null) {
            $rubric = new Rubric();
        }

        return $this->createFormBuilder($rubric)
            ->add('name', TextType::class, ['label' => 'Название'])
            ->add('sort', IntegerType::class, ['label' => 'Сортировка'])
            ->add('save', SubmitType::class, ['label' => 'Сохранить'])
            ->getForm();
    }

    /**
     * @param $id
     * @return object|null
     */
    protected function findRubric($id)
    {
        if (($rubric = $this->getRubricRepository()->find($id)) === null) {
            throw new NotFoundHttpException('rubric not found');
        }

        return $rubric;
    }

    /**
     * @return RubricRepository|ObjectRepository
     */
    protected function getRubricRepository()
    {
        return $this->getDoctrine()->getRepository(Rubric::class);
    }
}
