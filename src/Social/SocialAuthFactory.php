<?php

namespace App\Social;

class SocialAuthFactory
{
    /** @var SocialAuthInterface[] */
    protected array $services;

    public function __construct()
    {
        $this->services = [
            new VkAuth(),
        ];
    }

    public function getLinks(): array
    {
        $result = [];

        foreach ($this->services as $service) {
            $result[] = $service->getAuthLink();
        }

        return $result;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
