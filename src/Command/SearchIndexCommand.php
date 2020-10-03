<?php

namespace App\Command;

use App\Dto\SearchQuery;
use App\Repository\ArticleRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchIndexCommand extends Command
{
    protected const BATCH_SIZE = 500;

    protected LoggerInterface $logger;
    protected SearchService $searchService;
    protected EntityManagerInterface $entityManager;
    protected ArticleRepository $articleRepository;
    protected ProviderRepository $providerRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        LoggerInterface $logger,
        SearchService $searchService,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->logger = $logger;
        $this->searchService = $searchService;
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->providerRepository = $providerRepository;
        $this->programRepository = $programRepository;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:index:reindex')
            ->setDescription('Index all system entities');
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('start index');

        $searchQuery = (new SearchQuery())
            ->setPageItemCount(self::BATCH_SIZE);

        for ($page = 1; $page <= ceil($this->getArticlesCount() / self::BATCH_SIZE); $page++) {
            $searchQuery->setPage($page);

            foreach ($this->articleRepository->getPaginatorResult($searchQuery)->getItems() as $article) {
                $this->searchService->addArticleToIndex($article);
                $output->writeln(sprintf('Add article to index: %s', $article->getName()));
            }

            $this->entityManager->clear();
        }

        for ($page = 1; $page <= ceil($this->getProvidersCount() / self::BATCH_SIZE); $page++) {
            $searchQuery->setPage($page);

            foreach ($this->providerRepository->getPaginatorResult($searchQuery)->getItems() as $provider) {
                $this->searchService->addProviderToIndex($provider);
                $output->writeln(sprintf('Add provider to index: %s', $provider->getName()));
            }

            $this->entityManager->clear();
        }

        for ($page = 1; $page <= ceil($this->getProgramsCount() / self::BATCH_SIZE); $page++) {
            $searchQuery->setPage($page);

            foreach ($this->programRepository->getPaginatorResult($searchQuery)->getItems() as $program) {
                $this->searchService->addProgramToIndex($program);
                $output->writeln(sprintf('Add program to index: %s', $program->getName()));
            }

            $this->entityManager->clear();
        }

        $output->writeln('success');

        return 1;
    }

    protected function getArticlesCount(): int
    {
        try {
            return $this->articleRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function getProvidersCount(): int
    {
        try {
            return $this->providerRepository->createQueryBuilder('p')
                ->select('count(p.id)')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function getProgramsCount(): int
    {
        try {
            return $this->programRepository->createQueryBuilder('p')
                ->select('count(p.id)')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            return 0;
        }
    }
}
