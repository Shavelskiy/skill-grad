<?php

namespace App\Controller\Api;

use App\Entity\Service\Document;
use App\Entity\Service\ProviderService;
use App\Entity\User;
use App\Service\DocumentService;
use App\Service\PdfService;
use App\Service\PriceService;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route("/api/profile/provider-service")
 */
class ProviderServiceController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected RouterInterface $router;
    protected Environment $twig;
    protected PriceService $priceService;
    protected PdfService $pdfService;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        Environment $twig,
        PriceService $priceService,
        PdfService $pdfService
    ) {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->twig = $twig;
        $this->priceService = $priceService;
        $this->pdfService = $pdfService;
    }

    /**
     * @Route("/is-pro-account", name="api.provider-service.is-pro-account", methods={"GET"})
     */
    public function isProAccount(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse(['is_pro_account' => ($user->getProvider() && $user->getProvider()->isProAccount())]);
    }

    /**
     * @Route("/pro-account-price", name="api.provider-settings.pro-account-price", methods={"GET"})
     */
    public function proAccountPrice(): Response
    {
        return new JsonResponse(['price' => $this->priceService->getProAccountPrice()]);
    }

    /**
     * @Route("/buy-pro-account", name="api.provider-service.byu-pro-account", methods={"POST"})
     */
    public function buyProAccount(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ((($provider = $user->getProvider()) !== null) && $provider->isProAccount()) {
            return new JsonResponse([], 400);
        }

        $proAccountPrice = $this->priceService->getProAccountPrice();

        if ($provider->getBalance() < $proAccountPrice) {
            return new JsonResponse([], 400);
        }

        $providerService = (new ProviderService())
            ->setUser($user)
            ->setActive(true)
            ->setType(ProviderService::PRO_ACCOUNT)
            ->setPrice($proAccountPrice)
            ->setProvider($provider)
            ->setExpireAt((new DateTime())->add(new DateInterval('P1M')));

        $provider
            ->setBalance($provider->getBalance() - $proAccountPrice);

        $this->entityManager->persist($providerService);
        $this->entityManager->persist($provider);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/replenish", name="api.provider-service.replenish", methods={"POST"})
     */
    public function replenish(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $amount = (float)$request->get('amount');

        if ($amount < 1) {
            return new JsonResponse([], 400);
        }

        if (($provider = $user->getProvider()) === null) {
            return new JsonResponse([], 403);
        }

        $fileName = sprintf('%s_%s_%s.pdf', 'replenish', $provider->getId(), time());

        try {
            $this->pdfService->generate(
                $this->twig->render('pdf/replenish.html.twig', ['amount' => $amount]), $fileName
            );
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        $service = (new ProviderService())
            ->setPrice($amount)
            ->setUser($user)
            ->setProvider($provider)
            ->setActive(false)
            ->setType(ProviderService::REPLENISH);

        $document = (new Document())
            ->setPath($fileName)
            ->setName('Счет фактура')
            ->setService($service);

        $service->addDocument($document);

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return new JsonResponse([
            'path' => $this->router->generate(DocumentService::FILE_DOWNLOAD_PATH, ['document' => $document->getId()]),
        ]);
    }
}