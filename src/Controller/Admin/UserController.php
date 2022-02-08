<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Helpers\SearchHelper;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/admin/user")
 */
class UserController extends AbstractController
{
    protected UserRepository $userRepository;
    protected TranslatorInterface $translator;

    public function __construct(
        UserRepository $userRepository,
        TranslatorInterface $translator
    ) {
        $this->userRepository = $userRepository;
        $this->translator = $translator;
    }

    /**
     * @Route("", name="admin.user.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [User::class, UserInfo::class]);

        $paginator = $this->userRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(User $user): array
    {
        $userInfo = $user->getUserInfo();

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'phone' => ($userInfo !== null) ? $userInfo->getPhone() : '',
            'fullName' => ($userInfo !== null) ? $userInfo->getFullName() : '',
            'active' => $user->isActive(),
        ];
    }
}
