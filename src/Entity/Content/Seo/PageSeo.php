<?php

namespace App\Entity\Content\Seo;

use App\Entity\Content\Page;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class PageSeo extends AbstractSeo
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Content\Page", inversedBy="seo")
     */
    protected Page $page;

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $page): self
    {
        $this->page = $page;
        return $this;
    }
}
