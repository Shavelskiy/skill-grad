<?php

namespace App\Entity\Service;

use App\Entity\Provider;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProviderService extends AbstractService
{
    public const PRO_ACCOUNT = 'pro_account';

    public const TYPES = [
        self::PRO_ACCOUNT,
    ];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provider", inversedBy="services")
     */
    protected Provider $provider;

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }
}
