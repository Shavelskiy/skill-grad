<?php

namespace App\Command;

use App\Entity\Provider;
use App\Entity\ProviderRequisites;
use App\Entity\Upload;
use App\Entity\User;
use App\Entity\UserInfo;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseCommand extends Command
{
    protected HttpClientInterface $client;
    protected EntityManagerInterface $entityManager;
    protected UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        parent::__construct();
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function configure(): void
    {
        $this
            ->setName('app:parse')
            ->setDescription('Parse data');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = __DIR__ . '/../../files/providers_data.json';

        $providersData = (array)json_decode(file_get_contents($fileName));

        $progressBar = new ProgressBar($output, count($providersData));
        $progressBar->start();

        foreach ($providersData as $kek) {
            $progressBar->advance();
            $data = (array)$kek;

            $lol = (new Provider())
                ->setName($data['title'])
                ->setExternalLink($data['external_link'])
                ->setDescription(trim($data['description']));

            if ($data['image'] !== '/img/no_logo.png') {
                $uuid = Uuid::uuid4();
                $fileName = $uuid->toString() . '-' . time() . '.png';
                file_put_contents('public/upload/' . $fileName, fopen($data['image'], 'rb'));

                $image = (new Upload())->setName($fileName);

                $lol->setImage($image);

                $this->entityManager->persist($image);
            }

            $req = (new ProviderRequisites())
                ->setOrganizationName($data['title']);

            if (isset($data['address'])) {
                $req->setLegalAddress($data['address']);
            }

            $lol->setProviderRequisites($req);

            $req->setProvider($lol);

            if (isset($data['email'])) {
                $req->setMailingAddress($data['email']);

                $user = new User();
                $user->setEmail($data['email']);
                $user->setPassword($this->userPasswordEncoder->encodePassword($user, $this->randomPassword()));
                $user->setActive(true);

                $user->setRoles([User::ROLE_USER, User::ROLE_PROVIDER]);
                $user->setProvider($lol);

                $userInfo = new UserInfo();

                if (isset($data['phone'])) {
                    $phone = $data['phone'];
                    $phone = str_replace(['+', ' ', '-'], '', $phone);
                    $phone = substr($phone, 0, 11);

                    $userInfo->setPhone($phone);
                }

                $userInfo->setUser($user);

                $lol->setUser($user);

                $this->entityManager->persist($userInfo);
                $this->entityManager->persist($user);
            }

            $this->entityManager->persist($req);
            $this->entityManager->persist($lol);
        }

        $progressBar->finish();

        $this->entityManager->flush();

        return 1;
    }

    protected function parseProgramLinks(string $link): array
    {
        $response = $this->client->request('GET', "https://www.ucheba.ru/$link");

        $dom = new \DOMDocument();
        @$dom->loadHTML($response->getContent());

        foreach ($dom->getElementsByTagName('h1') as $kek) {
            $title = $kek->nodeValue;
        }

        foreach ($dom->getElementsByTagName('img') as $img) {
            $find = false;
            foreach ($img->attributes as $attribute) {
                if ($attribute->name === 'class' && $attribute->value === 'head-announce__img logo-uz') {
                    $find = true;
                }
            }

            if ($find) {
                foreach ($img->attributes as $attribute) {
                    if ($attribute->name === 'src') {
                        $image = $attribute->value;
                    }
                }
            }
        }

        $description = null;

        foreach ($dom->getElementsByTagName('section') as $section) {
            if ($description !== null) {
                continue;
            }

            $find = false;

            foreach ($section->attributes as $attribute) {
                if ($attribute->name === 'class' && $attribute->value === 'mb-section-large') {
                    $find = true;
                }
            }

            if ($find) {
                $kek = $section->getElementsByTagName('p');
                foreach ($kek as $lol) {
                    $description = $lol->nodeValue;
                }
            }
        }

        $provider = [
            'title' => $title,
            'image' => $image,
            'description' => $description,
        ];

        $response = $this->client->request('GET', "https://www.ucheba.ru/$link/contacts");

        $dom = new \DOMDocument();
        @$dom->loadHTML($response->getContent());

        $blocks = [];
        foreach ($dom->getElementsByTagName('div') as $div) {
            foreach ($div->attributes as $attribute) {
                if ($attribute->name === 'class' && $attribute->value === 'address-panel row') {
                    $blocks[] = $div;
                }
            }
        }

        foreach ($blocks as $key => $block) {
            if ($key === 0) {
                foreach ($block->getElementsByTagName('li') as $aa => $li) {
                    if ($aa === 0) {
                        foreach ($li->getElementsByTagName('a') as $a1) {
                            $provider['external_link'] = $a1->nodeValue;
                        }

                        if (!isset($provider['external_link'])) {
                            $provider['external_link'] = trim($li->nodeValue);
                        }
                    } elseif ($aa === 1) {
                        foreach ($li->getElementsByTagName('a') as $a1) {
                            $provider['email'] = $a1->nodeValue;
                        }
                    } elseif ($aa === 4) {
                        $provider['phone'] = $li->nodeValue;
                    }
                }
            } elseif ($key === 1) {
                foreach ($block->getElementsByTagName('li') as $aa => $li) {
                    if ($aa === 0) {
                        $provider['address'] = $li->nodeValue;
                    }
                }
            }
        }

        return $provider;
    }

    protected function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; ++$i) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
