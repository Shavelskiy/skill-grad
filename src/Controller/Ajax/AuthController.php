<?php

namespace App\Controller\Ajax;

use App\Entity\User;
use Exception;
use LogicException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Route("/ajax")
 */
class AuthController extends AbstractController
{
    protected CsrfTokenManagerInterface $csrfTokenManager;

    protected UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
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
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    public function resetPassword(Request $request, MailerInterface $mailer): JsonResponse
    {
        try {
            $token = new CsrfToken('reset-password', $request->get('_csrf_token'));
            if (!$this->csrfTokenManager->isTokenValid($token)) {
                throw new RuntimeException('Ошбика безопастности');
            }

            /** @var User $user */
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $request->get('email')]);

            if ($user === null) {
                throw new RuntimeException('Пользователь с таким E-mail не найден');
            }

            $user->generateResetPasswordToken();

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            try {
                $email = (new Email())
                    ->from('v.shavelsky@gmail.com')
                    ->to($user->getUsername())
                    ->subject('Восстановление пароля')
                    ->html($this->renderView('emails/forgot.password.html.twig', [
                        'link' => 'http://localhost:8080' . $this->generateUrl('site.index', [
                                'reset_password' => 1,
                                'token' => $user->getResetPasswordToken()->getHex()->toString(),
                            ])
                    ]));

                $mailer->send($email);
            } catch (Exception $e) {
                throw new RuntimeException('Произошла ошибка');
            }

            return new JsonResponse('На ваш email отправлено письмо');
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
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
            $token = new CsrfToken('new-password', $request->get('_csrf_token'));
            if (!$this->csrfTokenManager->isTokenValid($token)) {
                throw new RuntimeException('Ошбика безопастности');
            }

            $password = $request->get('password');

            if ($password !== $request->get('confirm-password')) {
                throw new RuntimeException('Пароли должны совпадать');
            }

            /** @var User $user */
            $user = $this->getDoctrine()->getRepository(User::class)
                ->findByResetPasswordToken($request->get('token'));

            if ($user === null) {
                throw new RuntimeException('Ошибка безопастности');
            }

            $user
                ->setPassword($this->userPasswordEncoder->encodePassword($user, $password))
                ->resetResetPasswordToken();

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('Ваш пароль успешно сменен');
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
