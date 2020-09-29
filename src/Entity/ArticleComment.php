<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ArticleComment
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="text")
     */
    protected string $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     */
    protected Article $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArticleComment", inversedBy="answers")
     */
    protected ?ArticleComment $parentComment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleComment", mappedBy="parentComment", cascade={"remove"})
     */
    protected Collection $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
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

    public function getParentComment(): ?ArticleComment
    {
        return $this->parentComment ?? null;
    }

    public function setParentComment(ArticleComment $parentComment): self
    {
        $this->parentComment = $parentComment;
        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): self
    {
        $this->answers = $answers;
        return $this;
    }
}
