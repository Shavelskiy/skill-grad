<?php

namespace App\Controller\Ajax;

use App\Entity\Program\Program;
use App\Entity\Program\ProgramQuestion;
use App\Entity\Program\ProgramRequest;
use App\Entity\User;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/program")
 */
class ProgramController extends AbstractController
{
    protected EntityManagerInterface $entityManger;
    protected ProgramRepository $programRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramRepository $programRepository
    ) {
        $this->entityManger = $entityManager;
        $this->programRepository = $programRepository;
    }

    /**
     * @Route("/request", name="ajax.program.request", methods={"POST"})
     */
    public function requestAction(Request $request): Response
    {
        $programId = $request->get('id');

        /** @var Program $program */
        $program = $this->programRepository->find((int)$programId);

        if ($program === null) {
            return new JsonResponse([], 404);
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($user->getProgramRequests()->filter(static function ($item) use ($programId) {
            /* @var ProgramRequest $item */
            return $item->getProgram()->getId() === $programId;
        })->count() > 0) {
            return new JsonResponse(['message' => 'К данной программе уже оставлена заявка!', 400]);
        }

        $programRequest = (new ProgramRequest())
            ->setUser($user)
            ->setProgram($program)
            ->setStatus(ProgramRequest::STATUS_NEW);

        $this->entityManger->persist($programRequest);
        $this->entityManger->flush();

        return new JsonResponse(['message' => 'Заявка к программе отправлена']);
    }

    /**
     * @Route("/question", name="ajax.program.request", methods={"POST"})
     */
    public function questionAction(Request $request): Response
    {
        $programId = $request->get('id');

        /** @var Program $program */
        $program = $this->programRepository->find((int)$programId);

        if ($program === null) {
            return new JsonResponse([], 404);
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($user->getProgramQuestions()->filter(static function ($item) use ($programId) {
            /* @var ProgramQuestion $item */
            return $item->getProgram()->getId() === $programId;
        })->count() > 5) {
            return new JsonResponse(['message' => 'Вы отправили слишком много вопросов к данной программе!', 400]);
        }

        $programQuestion = (new ProgramQuestion())
            ->setUser($user)
            ->setProgram($program)
            ->setQuestion($request->get('question'));

        $this->entityManger->persist($programQuestion);
        $this->entityManger->flush();

        return new JsonResponse(['message' => 'Вопрос отправлен']);
    }
}
