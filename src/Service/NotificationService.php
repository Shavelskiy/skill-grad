<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Environment;
use Twig\TemplateWrapper;

class NotificationService implements AuthMailerInterface
{
    protected MailerInterface $mailer;
    protected UrlGeneratorInterface $urlGenerator;
    protected Environment $templating;

    public function __construct(
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator,
        Environment $templating
    )
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
        $this->templating = $templating;
    }

    /**
     * @param $toEmail
     * @param $token
     */
    public function sendResetPasswordEmail($toEmail, $token): void
    {
        try {
            $email = (new Email())
                ->from('v.shavelsky@gmail.com')
                ->to($toEmail)
                ->subject('Восстановление пароля')
                ->html($this->templating->render('emails/forgot.password.html.twig', [
                    'link' => 'http://localhost:8080' . $this->urlGenerator->generate('site.index', [
                            'reset_password' => 1,
                            'token' => $token
                        ])
                ]));

            $this->mailer->send($email);
        } catch (Throwable $e) {
            throw new RuntimeException('Произошла ошибка');
        }
    }
}
