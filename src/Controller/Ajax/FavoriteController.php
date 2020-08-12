<?php

namespace App\Controller\Ajax;

use App\Entity\Provider;
use App\Entity\User;
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

    public function __construct(
        EntityManagerInterface $entityManager,
        ProviderRepository $providerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->providerRepository = $providerRepository;
    }

    /**
     * @Route("/provider", name="ajax.provider.favorite", methods={"POST"})
     */
    public function favoriteAction(Request $request): Response
    {
        try {
            /** @var Provider $provider */
            $provider = $this->providerRepository->find($request->get('id'));

            if ($provider === null) {
                throw new RuntimeException('');
            }

            /** @var User $user */
            $user = $this->getUser();

            $isRemove = $user->getFavoriteProviders()->contains($provider);

            if ($user->getFavoriteProviders()->contains($provider)) {
                $favoriteProviders = $user->getFavoriteProviders();
                $favoriteProviders->removeElement($provider);
                $user->setFavoriteProviders($favoriteProviders);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
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
}
