<?php

namespace App\Twig;

use App\Social\SocialAuthFactory;
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
     * @param bool $create
     * @return array
     */
    public function getSocialAuthLinks(bool $create = false): array
    {
        return (new SocialAuthFactory())->getLinks($create);
    }
}
