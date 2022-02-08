<?php

namespace App\Entity\Content;

use App\Entity\Content\Seo\PageSeo;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Page
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $slug;

    /**
     * @ORM\Column(type="text")
     */
    protected string $content;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Content\Seo\PageSeo", mappedBy="page")
     */
    protected ?PageSeo $seo;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getSeo(): ?PageSeo
    {
        return $this->seo ?? null;
    }

    public function setSeo(PageSeo $seo): self
    {
        $this->seo = $seo;
        return $this;
    }
}
