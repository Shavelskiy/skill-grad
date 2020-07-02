<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Repository\ArticleRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchIndexCommand extends Command
{
    protected LoggerInterface $logger;
    protected SearchService $searchServide;
    protected ArticleRepository $articleRepository;
    protected ProviderRepository $providerRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        LoggerInterface $logger,
        SearchService $searchService,
        ArticleRepository $articleRepository,
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->logger = $logger;
        $this->searchServide = $searchService;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('start index');

        /** @var Article $article */
        foreach ($this->articleRepository->findAll() as $article) {
            $this->searchServide->addArticleToIndex($article);
            $output->writeln(sprintf('Add article to index: %s', $article->getName()));
        }

        /** @var Provider $provider */
        foreach ($this->providerRepository->findAll() as $provider) {
            $this->searchServide->addProviderToIndex($provider);
            $output->writeln(sprintf('Add provider to index: %s', $provider->getName()));
        }

        /** @var Program $program */
        foreach ($this->programRepository->findAll() as $program) {
            $this->searchServide->addProgramToIndex($program);
            $output->writeln(sprintf('Add program to index: %s', $program->getName()));
        }

        $output->writeln('success');

        return 1;
    }
}
