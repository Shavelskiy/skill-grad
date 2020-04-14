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
            new TwigFunction('getSocialAuthLinks', [$this, 'getSocialAuthLinks']),
        ];
    }

    /**
     * @return array
     */
    public function getSocialAuthLinks(): array
    {
        return (new SocialAuthFactory())->getLinks();
    }
}
