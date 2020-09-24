<?php

namespace App\Controller\Ajax;

use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Entity\User;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/favorite")
 */
class FavoriteController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected ProviderRepository $providerRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository
    ) {
        $this->entityManager = $entityManager;
        $this->providerRepository = $providerRepository;
        $this->programRepository = $programRepository;
    }

    /**
     * @Route("/provider", name="ajax.provider.favorite", methods={"POST"})
     */
    public function favoriteProvider(Request $request): Response
    {
        try {
            /** @var Provider $provider */
            $provider = $this->providerRepository->find($request->get('id'));

            if ($provider === null) {
                throw new RuntimeException('');
            }

            /** @var User $user */
            $user = $this->getUser();

            $favoriteProviders = $user->getFavoriteProviders();

            $isRemove = $favoriteProviders->contains($provider);

            if ($isRemove) {
                $favoriteProviders->removeElement($provider);
                $user->setFavoriteProviders($favoriteProviders);

                $this->entityManager->persist($user);
            } else {
                $user->addFavoriteProvider($provider);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'message' => !$isRemove ? 'Провайдер успешно добавлен в избранное' : 'Провайдер успешно убран из избранного',
                'isAdded' => !$isRemove,
            ]);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Произошла ошибка при добавлении провайдера в избранное'], 400);
        }
    }

    /**
     * @Route("/program", name="ajax.program.favorite", methods={"POST"})
     */
    public function favoriteProgram(Request $request): Response
    {
        try {
            /** @var Program $program */
            $program = $this->programRepository->find($request->get('id'));

            if ($program === null) {
                throw new RuntimeException('');
            }

            /** @var User $user */
            $user = $this->getUser();

            $favoritePrograms = $user->getFavoritePrograms();

            $isRemove = $favoritePrograms->contains($program);

            if ($isRemove) {
                $favoritePrograms->removeElement($program);
                $user->setFavoritePrograms($favoritePrograms);

                $this->entityManager->persist($user);
            } else {
                $user->addFavoriteProgram($program);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'message' => !$isRemove ? 'Программа успешно добавлена в избранное' : 'Программа успешно убрана из избранного',
                'isAdded' => !$isRemove,
            ]);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Произошла ошибка при добавлении программы в избранное'], 400);
        }
    }
}
