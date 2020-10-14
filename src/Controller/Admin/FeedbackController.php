<?php

namespace App\Controller\Admin;

use App\Entity\Feedback;
use App\Helpers\SearchHelper;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/feedback")
 */
class FeedbackController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected FeedbackRepository $feedbackRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        FeedbackRepository $feedbackRepository
    ) {
        $this->entityManager = $entityManager;
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @Route("", name="admin.feedback.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Feedback::class]);

        $paginator = $this->feedbackRepository->getPaginatorResult($searchQuery);

        $items = [];
        foreach ($paginator->getItems() as $item) {
            $items[] = $this->prepareItem($item);
        }

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
    }

    protected function prepareItem(Feedback $item): array
    {
        return [
            'id' => $item->getId(),
            'author_name' => $item->getAuthorName(),
            'email' => $item->getEmail(),
            'text' => $item->getText(),
            'created_at' => $item->getCreatedAt()->format(DATE_ATOM),
        ];
    }

    /**
     * @Route("/{feedback}", name="admin.feedback.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(Feedback $feedback): Response
    {
        return new JsonResponse($this->prepareItem($feedback));
    }

    /**
     * @Route("", name="admin.feedback.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        $feedback = $this->feedbackRepository->find($request->get('id'));

        if ($feedback === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
