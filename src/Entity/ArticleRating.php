<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ArticleRating
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="ratings")
     */
    protected Article $article;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $like;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function isLike(): bool
    {
        return $this->like;
    }

    public function setLike(bool $like): self
    {
        $this->like = $like;
        return $this;
    }

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