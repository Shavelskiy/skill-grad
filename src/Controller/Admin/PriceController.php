<?php

namespace App\Controller\Admin;

use App\Entity\Service\ServicePrice;
use App\Repository\PriceServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/admin/price")
 */
class PriceController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected PriceServiceRepository $priceServiceRepository;
    protected TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        PriceServiceRepository $priceServiceRepository,
        TranslatorInterface $translator
    ) {
        $this->entityManager = $entityManager;
        $this->priceServiceRepository = $priceServiceRepository;
        $this->translator = $translator;
    }

    /**
     * @Route("", name="admin.price.index", methods={"GET"})
     */
    public function index(): Response
    {
        $prices = [];

        foreach ($this->priceServiceRepository->findAll() as $price) {
            $prices[] = $this->prepareItem($price);
        }

        return new JsonResponse([
            'items' => $prices,
        ]);
    }

    /**
     * @Route("/{priceService}", name="admin.price.view", methods={"GET"})
     */
    public function view(ServicePrice $priceService): Response
    {
        return new JsonResponse(
            $this->prepareItem($priceService)
        );
    }

    protected function prepareItem(ServicePrice $servicePrice): array
    {
        return [
            'id' => $servicePrice->getId(),
            'type' => $servicePrice->getType(),
            'title' => $this->translator->trans($servicePrice->getType(), [], ServicePrice::TRANSLATE_DOMAIN),
            'price' => $servicePrice->getPrice(),
        ];
    }

    /**
     * @Route("", name="admin.location.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        $priceService = $this->priceServiceRepository->find($request->get('id'));

        if ($priceService === null) {
            return new JsonResponse([], 404);
        }

        $priceService
            ->setPrice($request->get('price'));

        $this->entityManager->persist($priceService);
        $this->entityManager->flush();

        return new JsonResponse();
    }

}
