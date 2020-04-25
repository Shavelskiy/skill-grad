<?php

namespace App\Social;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

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

    public function getSocialAuthForRequest(Request $request): SocialAuthInterface
    {
        foreach ($this->getServices() as $service) {
            if ($service->support($request)) {
                return $service;
            }
        }

        throw new RuntimeException('this request not support social auth');
    }
}
