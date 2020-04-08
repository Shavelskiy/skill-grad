<?php

namespace App\Twig;

use App\Social\SocialAuthFactory;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AuthExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderLoginForm', [$this, 'renderLoginForm'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @param Environment $environment
     *
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function renderLoginForm(Environment $environment): string
    {
        $socialAuthFactory = new SocialAuthFactory();

        $links = $socialAuthFactory->getLinks();

        return $environment->render('components/login.form.html.twig', [
            'socialLinks' => $links,
        ]);
    }
}
