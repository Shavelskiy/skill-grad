<?php

namespace App\Entity\Service;

use App\Entity\Provider;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;

/**
 * @ORM\Entity()
 */
class ProviderService extends AbstractService
{
    public const PRO_ACCOUNT = 'pro_account';
    public const REPLENISH = 'replenish';

    public const TYPES = [
        self::PRO_ACCOUNT,
        self::REPLENISH,
    ];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provider", inversedBy="services")
     */
    protected Provider $provider;

    public function getTitle(): string
    {
        if ($this->getType() === self::PRO_ACCOUNT) {
            return 'Приобретение PRO аккаунта на 30 дней';
        }

        if ($this->getType() === self::REPLENISH) {
            return 'Пополнение счета';
        }

        throw new RuntimeException('service type is not available');
    }

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
