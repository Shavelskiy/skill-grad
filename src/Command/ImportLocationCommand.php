<?php

namespace App\Command;

use App\Entity\Location;
use App\Helpers\Translate;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class ImportLocationCommand extends Command
{
    protected EntityManagerInterface $em;
    protected LocationRepository $locationRepository;

    protected array $existingCodes = [];

    public function __construct(LocationRepository $locationRepository, EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->locationRepository = $locationRepository;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:import:location')
            ->setDescription('Import location from file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start import locations');

        $fileName = __DIR__ . '/../../files/locations.json';

        try {
            $this->doImport($fileName, $output);
        } catch (Throwable $e) {
            $output->writeln(sprintf('Import error: %s', $e->getMessage()));

            return 0;
        }

        $output->writeln('success import locaitons');

        return 1;

    }

    protected function getRootLocation(): Location
    {
        $locations = $this->locationRepository->findBy(['type' => Location::TYPE_COUNTRY]);

        if (!empty($locations)) {
            return current($locations);
        }

        $location = (new Location())
            ->setName('Россия')
            ->setCode('ru')
            ->setSort(0)
            ->setType(Location::TYPE_COUNTRY)
            ->setShowInList(false);

        $this->em->persist($location);

        return $location;
    }

    protected function doImport(string $fileName, OutputInterface $output): void
    {
        if (!file_exists($fileName)) {
            throw new RuntimeException('file not exists');
        }

        $data = json_decode(file_get_contents($fileName), true);

        $rootLocation = $this->getRootLocation();
        $regions = [];

        foreach ($data['region'] as $region) {
            $location = (new Location())
                ->setName($region['name'])
                ->setCode(Translate::rus2translit($region['name']))
                ->setType(Location::TYPE_REGION)
                ->setParentLocation($rootLocation);

            $output->writeln(sprintf('Add region: %s', $location->getName()));

            $this->em->persist($location);

            $regions[$region['id']] = $location;
        }

        foreach ($data['city'] as $city) {
            $location = (new Location())
                ->setName($city['name'])
                ->setType(Location::TYPE_CITY)
                ->setParentLocation($regions[$city['region_id']]);

            $location->setCode($this->generateCityCode($location));

            $output->writeln(sprintf('Add city: %s, region name: %s', $location->getName(), $location->getParentLocation()->getName()));

            $this->em->persist($location);
        }

        $this->em->flush();
    }

    protected function generateCityCode(Location $location): string
    {
        $code = Translate::rus2translit($location->getName());

        if (in_array($code, $this->existingCodes, true)) {
            $code .= '-' . substr($location->getParentLocation()->getCode(), 1, 10);
        }

        $this->existingCodes[] = $code;

        return $code;
    }
}
