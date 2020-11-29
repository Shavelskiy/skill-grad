<?php

namespace App\Entity\Content\Seo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DefaultSeo extends AbstractSeo
{
    /**
     * @ORM\Column(type="string")
     */
    protected string $pageSlug = '';

    /**
     * @ORM\Column(type="string")
     */
    protected string $pageDescription = '';

    public function getPageSlug(): string
    {
        return $this->pageSlug;
    }

    public function setPageSlug(string $pageSlug): self
    {
        $this->pageSlug = $pageSlug;
        return $this;
    }

    public function getPageDescription(): string
    {
        return $this->pageDescription;
    }

    public function setPageDescription(string $pageDescription): self
    {
        $this->pageDescription = $pageDescription;
        return $this;
    }
}
