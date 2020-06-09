<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Upload;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("", name="admin.article.create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $article = (new Article())
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'))
            ->setDetailText($request->get('detailText'));

        try {
            /** @var UploadedFile $uploadImage */
            if ($uploadImage = $request->files->get('uploadImage')) {
                $fileName = uniqid('', true) . '-' . time() . '.' . $uploadImage->guessExtension();

                try {
                    $uploadImage->move($this->getParameter('upload_dir'), $fileName);
                } catch (Exception $e) {
                    throw new RuntimeException('Ошибка при сохранении файла');
                }

                $articleImage = (new Upload())->setName($fileName);
                $article->setImage($articleImage);

                $this->getDoctrine()->getManager()->persist($articleImage);
            }

            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse();
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
