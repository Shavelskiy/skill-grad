<?php

namespace App\Controller\Ajax;

use App\Entity\User;
use App\EventListener\ConfirmRegisterListener;
use App\Service\ResetUserPasswordInterface;
use Exception;
use LogicException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        ResetUserPasswordInterface $resetUserPasswordService
    )
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->resetUserPasswordService = $resetUserPasswordService;
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
     * @param Request $request
     * @return JsonResponse
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
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("/new-password", name="ajax.auth.new.password")
     * @param Request $request
     * @return JsonResponse
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
            return new JsonResponse(['message' => $e->getMessage(),], 400);
        }
    }

    /**
     * @Route("/register", name="ajax.auth.register")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    public function registerAction(Request $request, MailerInterface $mailer): JsonResponse
    {
        try {
            if (!$this->isCsrfTokenValid('register', $request->get('_csrf_token'))) {
                throw new RuntimeException('Ошбика безопастности');
            }

            $password = $request->get('password');

            if ($password !== $request->get('confirm-password')) {
                throw new RuntimeException('Пароли должны совпадать');
            }

            try {
                $user = $this->getDoctrine()->getRepository(User::class)
                    ->findUserByEmail($request->get('email'));

                if ($user->isActive()) {
                    throw new RuntimeException('Пользователь с такие E-mail уже зарегистрирован');
                }
            } catch (NotFoundHttpException $e) {
                $user = new User();
                $user->setEmail($request->get('email'));
            } finally {
                $user->generateRegisterToken();
                $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));

                if ($request->get('role') === 'provider') {
                    $user->setRoles([User::ROLE_USER, User::ROLE_PROVIDER]);
                } else {
                    $user->setRoles([User::ROLE_USER]);
                }
            }

            try {
                $email = (new Email())
                    ->from('v.shavelsky@gmail.com')
                    ->to($user->getUsername())
                    ->subject('Потверждение регистрации')
                    ->html($this->renderView('emails/forgot.password.html.twig', [
                        'link' => 'http://localhost:8080' . $this->generateUrl('site.index', [
                                ConfirmRegisterListener::CONFIRM_REGISTRATION_KEY => 1,
                                'token' => $user->getRegisterToken()->getHex()->toString(),
                            ])
                    ]));

                $mailer->send($email);
            } catch (Exception $e) {
                throw new RuntimeException('Произошла ошибка');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse(['message' => 'На ваш email отправлено письмо с подтверждением']);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage(),], 400);
        }
    }
}
