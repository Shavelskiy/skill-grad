<?php

namespace App\Entity;

use App\Entity\Content\Seo\ArticleSeo;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected User $author;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $sort = 100;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active = false;

    /**
     * @ORM\Column(type="text")
     */
    protected string $previewText;

    /**
     * @ORM\Column(type="text")
     */
    protected string $detailText;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected ?Upload $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     */
    protected Category $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleRating", mappedBy="article")
     */
    protected Collection $ratings;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $showOnMain = false;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $views = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $readingTime = 0;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteArticles")
     */
    protected Collection $favoriteUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleComment", mappedBy="article")
     */
    protected Collection $comments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Content\Seo\ArticleSeo", mappedBy="article")
     */
    protected ?ArticleSeo $seo;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getPreviewText(): string
    {
        return $this->previewText;
    }

    public function setPreviewText(string $previewText): self
    {
        $this->previewText = $previewText;
        return $this;
    }

    public function getDetailText(): string
    {
        return $this->detailText;
    }

    public function setDetailText(string $detailText): self
    {
        $this->detailText = $detailText;
        return $this;
    }

    public function getImage(): ?Upload
    {
        return $this->image;
    }

    public function setImage(?Upload $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function isShowOnMain(): bool
    {
        return $this->showOnMain;
    }

    public function setShowOnMain(bool $showOnMain): self
    {
        $this->showOnMain = $showOnMain;
        return $this;
    }

    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function setRatings(Collection $ratings): self
    {
        $this->ratings = $ratings;
        return $this;
    }

    public function addRating(ArticleRating $articleRating): self
    {
        $this->ratings->add($articleRating);
        return $this;
    }

    public function getLikesCount(): int
    {
        return $this->getRatings()->filter(fn (ArticleRating $articleRating) => $articleRating->isLike())->count();
    }

    public function getDisLikesCount(): int
    {
        return $this->getRatings()->filter(fn (ArticleRating $articleRating) => !$articleRating->isLike())->count();
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;
        return $this;
    }

    public function getReadingTime(): int
    {
        return $this->readingTime;
    }

    public function setReadingTime(int $readingTime): self
    {
        $this->readingTime = $readingTime;
        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments ?? new ArrayCollection();
    }

    public function getRootComments(): Collection
    {
        return $this->getComments()->filter(fn (ArticleComment $comment) => $comment->getParentComment() === null);
    }

    public function getSeo(): ?ArticleSeo
    {
        return $this->seo ?? null;
    }

    public function setSeo(ArticleSeo $seo): self
    {
        $this->seo = $seo;
        return $this;
    }
}
