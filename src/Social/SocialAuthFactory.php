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
            new OkAuth(),
        ];
    }

    public function getLinks(bool $create = false): array
    {
        $result = [];

        foreach ($this->services as $service) {
            $result[] = $service->getAuthLink($create);
        }

        return $result;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
