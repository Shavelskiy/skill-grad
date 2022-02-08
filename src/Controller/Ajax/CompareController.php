<?php

namespace App\Controller\Ajax;

use App\Helpers\CompareHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/compare")
 */
class CompareController extends AbstractController
{
    /**
     * @Route("/add", name="ajax.compare.add")
     */
    public function add(Request $request): Response
    {
        $compareProgramIds = $this->getCompareProgramsFromRequest($request);

        $programId = (int)($request->get('id'));

        if ($programId < 1) {
            return new JsonResponse(['count' => count($compareProgramIds)]);
        }

        if (in_array($programId, $compareProgramIds, true)) {
            return $this->createResponse(
                $this->removeProgramFromCompare($compareProgramIds, $programId), 'Программа убрана из сравнения'
            );
        }

        $compareProgramIds[] = $programId;

        return $this->createResponse(
            $compareProgramIds, 'Программа добавлена в сравнение'
        );
    }

    /**
     * @Route("/remove", name="ajax.compare.remove")
     */
    public function remove(Request $request): Response
    {
        $compareProgramIds = $this->getCompareProgramsFromRequest($request);

        $programId = (int)($request->get('id'));

        if ($programId < 1) {
            return new JsonResponse(['count' => count($compareProgramIds)]);
        }

        if (!in_array($programId, $compareProgramIds, true)) {
            return new JsonResponse(['message' => 'Программы нет в сравнение'], 400);
        }

        return $this->createResponse(
            $this->removeProgramFromCompare($compareProgramIds, $programId), 'Программа удалена из сравнения'
        );
    }

    /**
     * @Route("/clear", name="ajax.compare.clear")
     */
    public function clear(): Response
    {
        $response = new JsonResponse();

        $response->headers->clearCookie(CompareHelper::COMPARE_PROGRAMS_KEY);

        return $response;
    }

    protected function getCompareProgramsFromRequest(Request $request): array
    {
        return CompareHelper::getCompareProgramsFromParameterBag($request->cookies);
    }

    protected function removeProgramFromCompare(array $compareProgramIds, int $programId): array
    {
        return array_filter($compareProgramIds, static function ($item) use ($programId) {
            return $item !== $programId;
        });
    }

    protected function createResponse(array $compareProgramIds, string $message = ''): Response
    {
        $response = new JsonResponse([
            'count' => count($compareProgramIds),
            'message' => $message,
        ]);

        $response->headers->setCookie(Cookie::create(CompareHelper::COMPARE_PROGRAMS_KEY, json_encode($compareProgramIds)));

        return $response;
    }
}
