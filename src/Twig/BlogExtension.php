<?php

namespace App\Twig;

use App\Entity\Article;
use App\Entity\ArticleRating;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getArticleLikeClass', [$this, 'getArticleLikeClass']),
            new TwigFunction('getArticleDislikeClass', [$this, 'getArticleDislikeClass']),
        ];
    }

    public function getArticleLikeClass(Article $article, ?User $user = null): string
    {
        if ($user === null) {
            return 'disabled';
        }

        /** @var ArticleRating $rating */
        foreach ($article->getRatings() as $rating) {
            if ($rating->getUser()->getId() === $user->getId()) {
                return $rating->isLike() ? 'active' : '';
            }
        }

        return '';
    }

    public function getArticleDislikeClass(Article $article, ?User $user = null): string
    {
        if ($user === null) {
            return 'disabled';
        }

        /** @var ArticleRating $rating */
        foreach ($article->getRatings() as $rating) {
            if ($rating->getUser()->getId() === $user->getId()) {
                return !$rating->isLike() ? 'active' : '';
            }
        }

        return '';
    }
}
