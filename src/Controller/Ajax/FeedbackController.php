<?php

namespace App\Controller\Ajax;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/feedback")
 */
class FeedbackController extends AbstractController
{
    protected EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("", name="ajax.feedback.index", methods={"POST"})
     */
    public function feedback(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('feedback', $request->get('_csrf_token'))) {
            return new JsonResponse(['message' => 'Ошбика безопастности'], 400);
        }

        try {
            $feedback = (new Feedback())
                ->setAuthorName($request->get('author_name'))
                ->setEmail($request->get('email'))
                ->setText($request->get('text'));

            $this->entityManager->persist($feedback);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Сообщение успешно отправлено!']);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Произошла ошибка при отправке сообщения!'], 400);
        }
    }
}
