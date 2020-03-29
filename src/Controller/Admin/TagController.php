<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tags")
 */
class TagController extends AdminAbstractController
{
    /**
     * @Route("/", name="admin.tag.index", methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        return $this->render('admin/tag/index.html.twig');
    }

    /**
     * @Route("/{id}", name="admin.tag.show", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        dump($id);
        dd('show');
    }

    /**
     * @Route("/create", name="admin.tag.create", methods={"GET", "HEAD"})
     */
    public function create(): Response
    {
        $tag = new Tag();

        return $this->render('admin/tag/create.html.twig', [
            'form' => $this->getForm($tag)->createView(),
        ]);
    }

    /**
     * @Route("/create", name="admin.tag.store", methods={"POST", "PUT"})
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $form = $this->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{tag}/edit", name="admin.tag.edit", methods={"GET", "HEAD"})
     */
    public function edit(): Response
    {
        dd('edit');
    }

    /**
     * @Route("/{tag}/edit", name="admin.tag.update", methods={"POST", "PUT"})
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

    /**
     * @param $tag
     * @return FormInterface
     */
    protected function getForm($tag = null): FormInterface
    {
        if ($tag === null) {
            $tag = new Tag();
        }

        return $this->createFormBuilder($tag)
            ->add('name', TextType::class, ['label' => 'Название'])
            ->add('sort', IntegerType::class, ['label' => 'Сортировка'])
            ->add('save', SubmitType::class, ['label' => 'Сохранить'])
            ->getForm();
    }
}
