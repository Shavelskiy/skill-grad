<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Repository\TagRepository;
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
 * @Route("/admin/tags")
 */
class TagController extends AdminAbstractController
{
    /**
     * @Route("/", name="admin.tag.index", methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        return $this->render('admin/tag/index.html.twig', [
            'tags' => $this->getTagRepository()->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="admin.tag.create", methods={"GET", "HEAD"})
     */
    public function create(): Response
    {
        $tag = new Tag();

        $maxSortTag = $this->getTagRepository()->getTagWithMaxSort();
        $tag->setSort(($maxSortTag !== null) ? ($maxSortTag->getSort() + 100) : 100);

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.tag.edit", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @return Response
     */
    public function edit($id): Response
    {
        $tag = $this->findTag($id);

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $this->getForm($tag)->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.tag.update", methods={"POST", "PUT"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request): Response
    {
        $tag = $this->findTag($id);

        $form = $this->getForm($tag)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $this->getForm($tag)->createView(),
        ]);
    }

    /**
     * @Route("/{id}/destroy", name="admin.tag.destroy", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     * @return Response
     */
    public function destroy($id): Response
    {
        $tag = $this->findTag($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();

        return $this->redirectToRoute('admin.tag.index');
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

    /**
     * @param $id
     * @return object|null
     */
    protected function findTag($id)
    {
        if (($tag = $this->getTagRepository()->find($id)) === null) {
            throw new NotFoundHttpException('tag not found');
        }

        return $tag;
    }

    /**
     * @return TagRepository|ObjectRepository
     */
    protected function getTagRepository()
    {
        return $this->getDoctrine()->getRepository(Tag::class);
    }
}
