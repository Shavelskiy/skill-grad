<?php

namespace App\Entity\Content\Seo;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="seo")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap({
 *     "default" = "DefaultSeo",
 *     "provider" = "ProviderSeo",
 *     "article" = "ArticleSeo",
 *     "program" = "ProgramSeo",
 *     "page" = "PageSeo",
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractSeo
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $metaTitle = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $metaKeywords = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $metaDescription = '';

    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;
        return $this;
    }

    public function getMetaKeywords(): string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }
}
