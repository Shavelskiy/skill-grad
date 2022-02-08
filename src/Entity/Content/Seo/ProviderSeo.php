<?php

namespace App\Entity\Content\Seo;

use App\Entity\Provider;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProviderSeo extends AbstractSeo
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Provider", inversedBy="seo")
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
