<?php

namespace App\Controller\Ajax;

use App\Service\User\RegisterUserInterface;
use App\Service\User\ResetUserPasswordInterface;
use Exception;
use LogicException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Route("/ajax")
 */
class AuthController extends AbstractController
{
    protected CsrfTokenManagerInterface $csrfTokenManager;
    protected UserPasswordEncoderInterface $userPasswordEncoder;
    protected ResetUserPasswordInterface $resetUserPasswordService;
    protected RegisterUserInterface $registerUserService;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        ResetUserPasswordInterface $resetUserPasswordService,
        RegisterUserInterface $registerUserService
    ) {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->resetUserPasswordService = $resetUserPasswordService;
        $this->registerUserService = $registerUserService;
    }

    /**
     * @Route("/login", name="ajax.auth.login")
     */
    public function login(): Response
    {
        return $this->redirectToRoute('site.index');
    }

    /**
     * @Route("/logout", name="ajax.auth.logout")
     */
    public function logout(): void
    {
        throw new LogicException('Метод должен быть для того, чтобы было имя и middleware смог перехватить его');
    }

    /**
     * @Route("/reset-password", name="ajax.auth.reset.password")
     */
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            if (!$this->isCsrfTokenValid('reset-password', $request->get('_csrf_token'))) {
                throw new RuntimeException('Ошбика безопастности');
            }

            $email = $request->get('email', '');

            if (empty($email)) {
                throw new RuntimeException('Заполните email');
            }

            $this->resetUserPasswordService->initResetUserPassword($email);

            return new JsonResponse(['message' => 'На ваш email отправлено письмо']);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Произошла ошибка'], 400);
        }
    }

    /**
     * @Route("/new-password", name="ajax.auth.new.password")
     */
    public function newPassword(Request $request): JsonResponse
    {
        try {
            if (!$this->isCsrfTokenValid('new-password', $request->get('_csrf_token'))) {
                throw new RuntimeException('Ошбика безопастности');
            }

            $password = $request->get('password', '');

            if ($password !== $request->get('confirm-password', '')) {
                throw new RuntimeException('Пароли должны совпадать');
            }

            $token = $request->get('token', '');

            if (empty($password) || empty($token)) {
                throw new RuntimeException('Ошибка валидации входных данных');
            }

            $this->resetUserPasswordService->resetUserPassword($token, $password);

            return new JsonResponse(['message' => 'Ваш пароль успешно сменен']);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Произошла ошибка'], 400);
        }
    }

    /**
     * @Route("/register", name="ajax.auth.register")
     */
    public function register(Request $request): JsonResponse
    {
        try {
            if (!$this->isCsrfTokenValid('register', $request->get('_csrf_token'))) {
                throw new RuntimeException('Ошбика безопастности');
            }

            $password = $request->get('password');

            if ($password !== $request->get('confirm-password')) {
                throw new RuntimeException('Пароли должны совпадать');
            }

            $email = $request->get('email', '');

            if (empty($email)) {
                throw new RuntimeException('Ошибка валидации входных данных');
            }

            $this->registerUserService->registerUser($request->get('email'), $password, $request->get('role') === 'provider');

            return new JsonResponse(['message' => 'На ваш email отправлено письмо с подтверждением']);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
