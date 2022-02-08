<?php

namespace App\Entity\Content\Seo;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ArticleSeo extends AbstractSeo
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Article", inversedBy="seo")
     */
    protected Article $article;

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;
        return $this;
    }
}
