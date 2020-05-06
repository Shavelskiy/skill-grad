<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/profile/programs")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="api.profile.programs.index")
     */
    public function index(Request $request): JsonResponse
    {
        $page = (int)($request->get('page', 1));

        return new JsonResponse([
            'currentPage' => $page,
            'totalPages' => 10,
            'items' => [
                [ 
                    'id' => 1,
                    'active' => true,
                    'name' => 'Маркетинг (многопрофильный бакалавариат "Маркетинг и управление продажами")',
                    'categories' => ['kek', 'lol'],
                    'requests' => [
                        'total' => $page,
                        'new' => $page,
                    ],
                    'questions' =>[
                        'total' => 433,
                        'new' => 23,
                    ],
                    'answers' => [
                        'total' => 433,
                        'new' => 54,
                    ],
                ],
                [ 
                    'id' => 2,
                    'active' => true,
                    'name' => 'Маркетинг (многопрофильный бакалавариат "Маркетинг и управление продажами")',
                    'categories' => ['1323', 'jjjjjj'],
                    'requests' => [
                        'total' => 234,
                        'new' => 45,
                    ],
                    'questions' =>[
                        'total' => 433,
                        'new' => 23,
                    ],
                    'answers' => [
                        'total' => 433,
                        'new' => 54,
                    ],
                ],
                [ 
                    'id' => 3,
                    'active' => true,
                    'name' => 'Маркетинг (многопрофильный бакалавариат "Маркетинг и управление продажами")',
                    'categories' => ['kjdsfsjdflkj', 'kdfskjdf'],
                    'requests' => [
                        'total' => 234,
                        'new' => 45,
                    ],
                    'questions' =>[
                        'total' => 433,
                        'new' => 23,
                    ],
                    'answers' => [
                        'total' => 433,
                        'new' => 54,
                    ],
                ],
                [ 
                    'id' => 4,
                    'active' => true,
                    'name' => 'Маркетинг (многопрофильный бакалавариат "Маркетинг и управление продажами")',
                    'categories' => ['fjsdfjk', 'fjksdf', 'fkdsf', 'dfsf', 'sdjkf'],
                    'requests' => [
                        'total' => 234,
                        'new' => 45,
                    ],
                    'questions' =>[
                        'total' => 433,
                        'new' => 23,
                    ],
                    'answers' => [
                        'total' => 433,
                        'new' => 54,
                    ],
                ],
            ],
        ]);
    }
}
