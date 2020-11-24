<?php

namespace App\Service;

use App\EventSubscriber\ConfirmRegisterListener;
use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Environment;

class NotificationService implements AuthMailerInterface
{
    protected MailerInterface $mailer;
    protected UrlGeneratorInterface $urlGenerator;
    protected Environment $templating;
    protected string $host;

    public function __construct(
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator,
        Environment $templating,
        ParameterBagInterface $params
    ) {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
        $this->templating = $templating;

        $this->host = sprintf('%s://%s',
            $params->get('app_scheme'),
            $params->get('app_host'),
        );
    }

    /**
     * @param $toEmail
     * @param $token
     */
    public function sendResetPasswordEmail(string $toEmail, string $token): void
    {
        try {
            $email = (new Email())
                ->from('d.uzhikov@mail.ru')
                ->to($toEmail)
                ->subject('Восстановление пароля')
                ->html($this->templating->render('emails/forgot.password.html.twig', [
                    'link' => $this->host . $this->urlGenerator->generate('site.index', [
                            'reset_password' => 1,
                            'token' => $token,
                        ]),
                ]));

            $this->mailer->send($email);
        } catch (Throwable $e) {
            throw new RuntimeException('Произошла ошибка');
        }
    }

    public function sendRegisterEmail(string $toEmail, string $token): void
    {
        try {
            $email = (new Email())
                ->from('d.uzhikov@mail.ru')
                ->to($toEmail)
                ->subject('Потверждение регистрации')
                ->html($this->templating->render('emails/confirm.register.html.twig', [
                    'link' => $this->host . $this->urlGenerator->generate('site.index', [
                            ConfirmRegisterListener::CONFIRM_REGISTRATION_KEY => 1,
                            'token' => $token,
                        ]),
                ]));

            $this->mailer->send($email);
        } catch (Throwable $e) {
            throw new RuntimeException('Произошла ошибка при отправке письма.');
        }
    }
}
