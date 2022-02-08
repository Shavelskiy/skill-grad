<?php

namespace App\Twig;

use App\Social\SocialAuthFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AuthExtension extends AbstractExtension
{
    protected SocialAuthFactory $socialAuthFactory;

    public function __construct(SocialAuthFactory $socialAuthFactory)
    {
        $this->socialAuthFactory = $socialAuthFactory;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSocialAuthLinks', [$this, 'getSocialAuthLinks']),
        ];
    }

    public function getSocialAuthLinks(): array
    {
        return $this->socialAuthFactory->getLinks();
    }
}
