<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Program\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KekCommand extends Command
{
    protected EntityManagerInterface $entityManager;
    protected ProgramRepository $programRepository;
    protected CategoryRepository $categoryRepository;
    protected HttpClientInterface $client;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramRepository $programRepository,
        CategoryRepository $categoryRepository,
        HttpClientInterface $client
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->programRepository = $programRepository;
        $this->categoryRepository = $categoryRepository;
        $this->client = $client;
    }

    protected const LINKS = [
        29 => [
            'https://www.ucheba.ru/for-specialists/courses/architecture',
            'https://www.ucheba.ru/for-specialists/courses/architecture?s=30',
            'https://www.ucheba.ru/for-specialists/courses/architecture?s=60',
        ],
        30 => [
            'https://www.ucheba.ru/for-specialists/courses/restoration',
            'https://www.ucheba.ru/for-specialists/courses/building?s=30',
            'https://www.ucheba.ru/for-specialists/courses/building?s=60',
            'https://www.ucheba.ru/for-specialists/courses/building?s=90',
            'https://www.ucheba.ru/for-specialists/courses/building?s=120',
            'https://www.ucheba.ru/for-specialists/courses/building?s=150',
            'https://www.ucheba.ru/for-specialists/courses/building?s=180',
            'https://www.ucheba.ru/for-specialists/courses/building?s=210',
            'https://www.ucheba.ru/for-specialists/courses/building?s=240',
        ],
        31 => [
            'https://www.ucheba.ru/for-specialists/courses/building',
        ],
        32 => [
            'https://www.ucheba.ru/for-specialists/courses/urbanistics',
        ],
        33 => [
            'https://www.ucheba.ru/for-specialists/courses/drawing',
        ],
        34 => [
            'https://www.ucheba.ru/for-specialists/courses/job-safety',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=30',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=60',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=90',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=120',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=150',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=180',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=210',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=240',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=270',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=300',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=330',
        ],
        35 => [
            'https://www.ucheba.ru/for-specialists/courses/military-science',
        ],
        36 => [
            'https://www.ucheba.ru/for-specialists/courses/art',
        ],
        37 => [
            'https://www.ucheba.ru/for-specialists/courses/history',
        ],
        38 => [
            'https://www.ucheba.ru/for-specialists/courses/cultural-science',
        ],
        39 => [
            'https://www.ucheba.ru/for-specialists/courses/linguistics',
        ],
        40 => [
            'https://www.ucheba.ru/for-specialists/courses/literatute',
        ],
        41 => [
            'https://www.ucheba.ru/for-specialists/courses/social-science',
        ],
        42 => [
            'https://www.ucheba.ru/for-specialists/courses/pedagogy',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=30',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=60',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=90',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=120',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=150',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=180',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=210',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=240',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=270',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=300',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=330',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=360',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=390',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=420',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=450',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=480',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=510',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=540',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=570',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=600',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=630',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=660',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=690',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=720',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=750',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=780',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=810',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=840',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=870',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=900',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=930',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=960',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=990',
        ],
        43 => [
            'https://www.ucheba.ru/for-specialists/courses/political-science',
        ],
        44 => [
            'https://www.ucheba.ru/for-specialists/courses/psychology',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=30',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=60',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=90',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=120',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=150',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=180',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=210',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=240',
        ],
        45 => [
            'https://www.ucheba.ru/for-specialists/courses/religiya',
        ],
        46 => [
            'https://www.ucheba.ru/for-specialists/courses/sociology',
        ],
        47 => [
            'https://www.ucheba.ru/for-specialists/courses/filologiya',
        ],
        48 => [
            'https://www.ucheba.ru/for-specialists/courses/philosophy',
        ],
        49 => [
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=30',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=60',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=90',
        ],
        50 => [
            'https://www.ucheba.ru/for-specialists/courses/game-dizayn',
        ],
        51 => [
            'https://www.ucheba.ru/for-specialists/courses/graphic-design',
            'https://www.ucheba.ru/for-specialists/courses/graphic-design?s=30',
            'https://www.ucheba.ru/for-specialists/courses/graphic-design?s=60',
        ],
        52 => [
            'https://www.ucheba.ru/for-specialists/courses/interior-design',
            'https://www.ucheba.ru/for-specialists/courses/interior-design?s=30',
        ],
        53 => [
            'https://www.ucheba.ru/for-specialists/courses/fashion-design',
        ],
        54 => [
            'https://www.ucheba.ru/for-specialists/courses/computer-graphics',
            'https://www.ucheba.ru/for-specialists/courses/computer-graphics?s=30',
            'https://www.ucheba.ru/for-specialists/courses/computer-graphics?s=60',
            'https://www.ucheba.ru/for-specialists/courses/computer-graphics?s=90',
        ],
        55 => [
            'https://www.ucheba.ru/for-specialists/courses/landscape-design',
            'https://www.ucheba.ru/for-specialists/courses/landscape-design?s=30',
        ],
        56 => [
            'https://www.ucheba.ru/for-specialists/courses/industrial-design',
        ],
        57 => [
            'https://www.ucheba.ru/for-specialists/courses/floristics',
        ],
        58 => [
            'https://www.ucheba.ru/for-specialists/courses/digital-design',
            'https://www.ucheba.ru/for-specialists/courses/digital-design?s=30',
            'https://www.ucheba.ru/for-specialists/courses/digital-design?s=60',
        ],
        59 => [
            'https://www.ucheba.ru/for-specialists/courses/english',
            'https://www.ucheba.ru/for-specialists/courses/english?s=30',
            'https://www.ucheba.ru/for-specialists/courses/english?s=60',
            'https://www.ucheba.ru/for-specialists/courses/english?s=90',
            'https://www.ucheba.ru/for-specialists/courses/english?s=120',
            'https://www.ucheba.ru/for-specialists/courses/english?s=150',
            'https://www.ucheba.ru/for-specialists/courses/english?s=180',
            'https://www.ucheba.ru/for-specialists/courses/english?s=210',
        ],
        60 => [
            'https://www.ucheba.ru/for-specialists/courses/arabic',
        ],
        61 => [
            'https://www.ucheba.ru/for-specialists/courses/armenian',
        ],
        62 => [
            'https://www.ucheba.ru/for-specialists/courses/bulgarian',
        ],
        63 => [
            'https://www.ucheba.ru/for-specialists/courses/dutch',
        ],
        64 => [
            'https://www.ucheba.ru/for-specialists/courses/greek',
        ],
        65 => [
            'https://www.ucheba.ru/for-specialists/courses/danish',
        ],
        66 => [
            'https://www.ucheba.ru/for-specialists/courses/hebrew',
        ],
        67 => [
            'https://www.ucheba.ru/for-specialists/courses/indoneziyskiy',
        ],
        68 => [
            'https://www.ucheba.ru/for-specialists/courses/icelandic',
        ],
        69 => [
            'https://www.ucheba.ru/for-specialists/courses/spanish',
            'https://www.ucheba.ru/for-specialists/courses/spanish?s=30',
        ],
        70 => [
            'https://www.ucheba.ru/for-specialists/courses/italian',
            'https://www.ucheba.ru/for-specialists/courses/italian?s=30',
        ],
        71 => [
            'https://www.ucheba.ru/for-specialists/courses/chinese',
        ],
        72 => [
            'https://www.ucheba.ru/for-specialists/courses/korean',
        ],
        73 => [
            'https://www.ucheba.ru/for-specialists/courses/latin',
        ],
        74 => [
            'https://www.ucheba.ru/for-specialists/courses/german',
            'https://www.ucheba.ru/for-specialists/courses/german?s=30',
        ],
        75 => [
            'https://www.ucheba.ru/for-specialists/courses/netherlandian',
        ],
        76 => [
            'https://www.ucheba.ru/for-specialists/courses/norwegian',
        ],
        77 => [
            'https://www.ucheba.ru/for-specialists/courses/polish',
        ],
        78 => [
            'https://www.ucheba.ru/for-specialists/courses/portuguese',
        ],
        79 => [
            'https://www.ucheba.ru/for-specialists/courses/romanian',
        ],
        80 => [
            'https://www.ucheba.ru/for-specialists/courses/russian',
            'https://www.ucheba.ru/for-specialists/courses/russian?s=30',
        ],
        81 => [
            'https://www.ucheba.ru/for-specialists/courses/serbian',
        ],
        82 => [
            'https://www.ucheba.ru/for-specialists/courses/turkish',
        ],
        83 => [
            'https://www.ucheba.ru/for-specialists/courses/farsi',
        ],
        84 => [
            'https://www.ucheba.ru/for-specialists/courses/finnish',
        ],
        85 => [
            'https://www.ucheba.ru/for-specialists/courses/french',
            'https://www.ucheba.ru/for-specialists/courses/french?s=30',
        ],
        86 => [
            'https://www.ucheba.ru/for-specialists/courses/hindi',
        ],
        87 => [
            'https://www.ucheba.ru/for-specialists/courses/croatian',
        ],
        88 => [
            'https://www.ucheba.ru/for-specialists/courses/czech',
        ],
        89 => [
            'https://www.ucheba.ru/for-specialists/courses/swedish',
        ],
        90 => [
            'https://www.ucheba.ru/for-specialists/courses/japanese',
        ],
        91 => [
            'https://www.ucheba.ru/for-specialists/courses/it-menedzhment',
            'https://www.ucheba.ru/for-specialists/courses/it-menedzhment?s=30',
        ],
        92 => [
            'https://www.ucheba.ru/for-specialists/courses/data-science',
            'https://www.ucheba.ru/for-specialists/courses/data-science?s=30',
            'https://www.ucheba.ru/for-specialists/courses/data-science?s=60',
            'https://www.ucheba.ru/for-specialists/courses/data-science?s=90',
        ],
        93 => [
            'https://www.ucheba.ru/for-specialists/courses/informatika-i-ikt',
        ],
        94 => [
            'https://www.ucheba.ru/for-specialists/courses/information-security',
            'https://www.ucheba.ru/for-specialists/courses/information-security?s=30',
            'https://www.ucheba.ru/for-specialists/courses/information-security?s=60',
        ],
        95 => [
            'https://www.ucheba.ru/for-specialists/courses/coding',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=30',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=60',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=90',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=120',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=150',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=180',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=210',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=240',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=270',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=300',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=330',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=360',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=390',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=420',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=450',
            'https://www.ucheba.ru/for-specialists/courses/coding?s=480',
        ],
        96 => [
            'https://www.ucheba.ru/for-specialists/courses/system-administration',
            'https://www.ucheba.ru/for-specialists/courses/system-administration?s=30',
            'https://www.ucheba.ru/for-specialists/courses/system-administration?s=60',
            'https://www.ucheba.ru/for-specialists/courses/system-administration?s=90',
            'https://www.ucheba.ru/for-specialists/courses/system-administration?s=120',
            'https://www.ucheba.ru/for-specialists/courses/system-administration?s=150',
        ],
        97 => [
            'https://www.ucheba.ru/for-specialists/courses/telecom',
        ],
        98 => [
            'https://www.ucheba.ru/for-specialists/courses/acting-techniques',
        ],
        99 => [
            'https://www.ucheba.ru/for-specialists/courses/craft-arts',
        ],
        100 => [
            'https://www.ucheba.ru/for-specialists/courses/paintings',
            'https://www.ucheba.ru/for-specialists/courses/paintings?s=30',
        ],
        101 => [
            'https://www.ucheba.ru/for-specialists/courses/art',
        ],
        102 => [
            'https://www.ucheba.ru/for-specialists/courses/writing',
        ],
        103 => [
            'https://www.ucheba.ru/for-specialists/courses/art-management',
        ],
        104 => [
            'https://www.ucheba.ru/for-specialists/courses/music',
        ],
        105 => [
            'https://www.ucheba.ru/for-specialists/courses/camera-work',
        ],
        106 => [
            'https://www.ucheba.ru/for-specialists/courses/prodyusirovanie',
        ],
        107 => [
            'https://www.ucheba.ru/for-specialists/courses/rezhissura',
        ],
        108 => [
            'https://www.ucheba.ru/for-specialists/courses/skulptura',
        ],
        109 => [
            'https://www.ucheba.ru/for-specialists/courses/photo',
            'https://www.ucheba.ru/for-specialists/courses/photo?s=30',
        ],
        110 => [
            'https://www.ucheba.ru/for-specialists/courses/choreography',
        ],
        111 => [
            'https://www.ucheba.ru/for-specialists/courses/bibliotechnoe-i-arhivnoe-delo',
            'https://www.ucheba.ru/for-specialists/courses/bibliotechnoe-i-arhivnoe-delo?s=30',
        ],
        112 => [
            'https://www.ucheba.ru/for-specialists/courses/art',
        ],
        113 => [
            'https://www.ucheba.ru/for-specialists/courses/history',
        ],
        114 => [
            'https://www.ucheba.ru/for-specialists/courses/cultural-science',
        ],
        115 => [
            'https://www.ucheba.ru/for-specialists/courses/religiya',
        ],
        116 => [
            'https://www.ucheba.ru/for-specialists/courses/philosophy',
        ],
        117 => [
            'https://www.ucheba.ru/for-specialists/courses/event-management',
        ],
        118 => [
            'https://www.ucheba.ru/for-specialists/courses/brand-management',
        ],
        119 => [
            'https://www.ucheba.ru/for-specialists/courses/web-marketing',
            'https://www.ucheba.ru/for-specialists/courses/web-marketing?s=30',
            'https://www.ucheba.ru/for-specialists/courses/web-marketing?s=60',
            'https://www.ucheba.ru/for-specialists/courses/web-marketing?s=90',
        ],
        120 => [
            'https://www.ucheba.ru/for-specialists/courses/marketing',
            'https://www.ucheba.ru/for-specialists/courses/marketing?s=30',
        ],
        121 => [
            'https://www.ucheba.ru/for-specialists/courses/advertising-pr',
            'https://www.ucheba.ru/for-specialists/courses/advertising-pr?s=30',
        ],
        122 => [
            'https://www.ucheba.ru/for-specialists/courses/journalism',
        ],
        123 => [
            'https://www.ucheba.ru/for-specialists/courses/publishing',
        ],
        124 => [
            'https://www.ucheba.ru/for-specialists/courses/new-media',
        ],
        125 => [
            'https://www.ucheba.ru/for-specialists/courses/redaktorskoe-delo',
        ],
        126 => [
            'https://www.ucheba.ru/for-specialists/courses/advertising-pr',
            'https://www.ucheba.ru/for-specialists/courses/advertising-pr?s=30',
        ],
        127 => [
            'https://www.ucheba.ru/for-specialists/courses/television',
        ],
        128 => [
            'https://www.ucheba.ru/for-specialists/courses/veterinariya',
        ],
        129 => [
            'https://www.ucheba.ru/for-specialists/courses/cosmetology',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=30',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=60',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=90',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=120',
        ],
        130 => [
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=30',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=60',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=90',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=120',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=150',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=180',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=210',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=240',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=270',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=300',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=330',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=360',
            'https://www.ucheba.ru/for-specialists/courses/lechebnoe-delo?s=390',
        ],
        131 => [
            'https://www.ucheba.ru/for-specialists/courses/massage',
            'https://www.ucheba.ru/for-specialists/courses/massage?s=30',
        ],
        132 => [
            'https://www.ucheba.ru/for-specialists/courses/medic-technologies',
        ],
        133 => [
            'https://www.ucheba.ru/for-specialists/courses/medicine-management',
            'https://www.ucheba.ru/for-specialists/courses/medicine-management?s=30',
        ],
        134 => [
            'https://www.ucheba.ru/for-specialists/courses/meal',
        ],
        135 => [
            'https://www.ucheba.ru/for-specialists/courses/sestrinskoe-delo',
            'https://www.ucheba.ru/for-specialists/courses/sestrinskoe-delo?s=30',
        ],
        136 => [
            'https://www.ucheba.ru/for-specialists/courses/stomatologiya',
            'https://www.ucheba.ru/for-specialists/courses/stomatologiya?s=30',
        ],
        137 => [
            'https://www.ucheba.ru/for-specialists/courses/pharmacy',
            'https://www.ucheba.ru/for-specialists/courses/pharmacy?s=30',
            'https://www.ucheba.ru/for-specialists/courses/pharmacy?s=60',
        ],
        138 => [
            'https://www.ucheba.ru/for-specialists/courses/modelnyy-biznes',
        ],
        139 => [
            'https://www.ucheba.ru/for-specialists/courses/cosmetology',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=30',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=60',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=90',
            'https://www.ucheba.ru/for-specialists/courses/cosmetology?s=120',
        ],
        140 => [
            'https://www.ucheba.ru/for-specialists/courses/makeup',
            'https://www.ucheba.ru/for-specialists/courses/makeup?s=30',
        ],
        141 => [
            'https://www.ucheba.ru/for-specialists/courses/nails',
        ],
        142 => [
            'https://www.ucheba.ru/for-specialists/courses/management-beauty-industry',
        ],
        143 => [
            'https://www.ucheba.ru/for-specialists/courses/fasion',
        ],
        144 => [
            'https://www.ucheba.ru/for-specialists/courses/barber',
        ],
        145 => [
            'https://www.ucheba.ru/for-specialists/courses/pedagogy',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=30',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=60',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=90',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=120',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=150',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=180',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=210',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=240',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=270',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=300',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=330',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=360',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=390',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=420',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=450',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=480',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=510',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=540',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=570',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=600',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=630',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=660',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=690',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=720',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=750',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=780',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=810',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=840',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=870',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=900',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=930',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=960',
            'https://www.ucheba.ru/for-specialists/courses/pedagogy?s=990',
        ],
        146 => [
            'https://www.ucheba.ru/for-specialists/courses/psychology',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=30',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=60',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=90',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=120',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=150',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=180',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=210',
            'https://www.ucheba.ru/for-specialists/courses/psychology?s=240',
        ],
        147 => [
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education',
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education?s=30',
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education?s=60',
        ],
        148 => [
            'https://www.ucheba.ru/for-specialists/courses/job-safety',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=30',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=60',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=90',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=120',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=150',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=180',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=210',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=240',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=270',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=300',
            'https://www.ucheba.ru/for-specialists/courses/job-safety?s=330',
        ],
        149 => [
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginners',
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginnerss=30',
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginners?s=60',
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginners?s=90',
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginners?s=120',
            'https://www.ucheba.ru/for-specialists/courses/computer-for-beginners?s=150',
        ],
        150 => [
            'https://www.ucheba.ru/for-specialists/courses/secretary',
            'https://www.ucheba.ru/for-specialists/courses/secretary?s=30',
            'https://www.ucheba.ru/for-specialists/courses/secretary?s=60',
            'https://www.ucheba.ru/for-specialists/courses/secretary?s=90',
        ],
        151 => [
            'https://www.ucheba.ru/for-specialists/courses/government',
            'https://www.ucheba.ru/for-specialists/courses/government?s=30',
        ],
        152 => [
            'https://www.ucheba.ru/for-specialists/courses/international-relations',
        ],
        153 => [
            'https://www.ucheba.ru/for-specialists/courses/social-science',
        ],
        154 => [
            'https://www.ucheba.ru/for-specialists/courses/political-science',
        ],
        155 => [
            'https://www.ucheba.ru/for-specialists/courses/religiya',
        ],
        156 => [
            'https://www.ucheba.ru/for-specialists/courses/social-management',
            'https://www.ucheba.ru/for-specialists/courses/social-management?s=30',
        ],
        157 => [
            'https://www.ucheba.ru/for-specialists/courses/sociology',
        ],
        158 => [
            'https://www.ucheba.ru/for-specialists/courses/corruption',
        ],
        159 => [
            'https://www.ucheba.ru/for-specialists/courses/sudebnaya-ekspertiza',
        ],
        160 => [
            'https://www.ucheba.ru/for-specialists/courses/tamozhennoe-delo',
        ],
        161 => [
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=30',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=60',
            'https://www.ucheba.ru/for-specialists/courses/jurisprudence?s=90',
        ],
        162 => [
            'https://www.ucheba.ru/for-specialists/courses/geography',
        ],
        163 => [
            'https://www.ucheba.ru/for-specialists/courses/geodeziya-i-zemleustroystvo',
            'https://www.ucheba.ru/for-specialists/courses/geodeziya-i-zemleustroystvo?s=30',
        ],
        164 => [
            'https://www.ucheba.ru/for-specialists/courses/geology',
            'https://www.ucheba.ru/for-specialists/courses/geology?s=30',
        ],
        165 => [
            'https://www.ucheba.ru/for-specialists/courses/hydrometeorology',
        ],
        166 => [
            'https://www.ucheba.ru/for-specialists/courses/prof',
        ],
        167 => [
            'https://www.ucheba.ru/for-specialists/courses/agriculture',
        ],
        168 => [
            'https://www.ucheba.ru/for-specialists/courses/ecology',
            'https://www.ucheba.ru/for-specialists/courses/ecology?s=30',
            'https://www.ucheba.ru/for-specialists/courses/ecology?s=60',
        ],
        169 => [
            'https://www.ucheba.ru/for-specialists/courses/personal-brand',
        ],
        170 => [
            'https://www.ucheba.ru/for-specialists/courses/communication-skill',
        ],
        171 => [
            'https://www.ucheba.ru/for-specialists/courses/oratory',
        ],
        172 => [
            'https://www.ucheba.ru/for-specialists/courses/razvitie-karery',
        ],
        173 => [
            'https://www.ucheba.ru/for-specialists/courses/soft-skills',
            'https://www.ucheba.ru/for-specialists/courses/soft-skills?s=30',
        ],
        174 => [
            'https://www.ucheba.ru/for-specialists/courses/emotional-intellect',
        ],
        175 => [
            'https://www.ucheba.ru/for-specialists/courses/imidzh-i-etiket',
        ],
        176 => [
            'https://www.ucheba.ru/for-specialists/courses/sport-management',
        ],
        177 => [
            'https://www.ucheba.ru/for-specialists/courses/fizkultura',
            'https://www.ucheba.ru/for-specialists/courses/fizkultura?s=30',
            'https://www.ucheba.ru/for-specialists/courses/fizkultura?s=60',
        ],
        178 => [
            'https://www.ucheba.ru/for-specialists/courses/cooking',
            'https://www.ucheba.ru/for-specialists/courses/cooking?s=30',
        ],
        179 => [
            'https://www.ucheba.ru/for-specialists/courses/autoservice',
        ],
        180 => [
            'https://www.ucheba.ru/for-specialists/courses/remont-bytovoy-tehniki',
        ],
        181 => [
            'https://www.ucheba.ru/for-specialists/courses/horeca',
            'https://www.ucheba.ru/for-specialists/courses/horeca?s=30',
        ],
        182 => [
            'https://www.ucheba.ru/for-specialists/courses/realty-management',
        ],
        183 => [
            'https://www.ucheba.ru/for-specialists/courses/aviaciya-i-raketostroenie',
        ],
        184 => [
            'https://www.ucheba.ru/for-specialists/courses/avtomatizaciya-proizvodstva',
        ],
        185 => [
            'https://www.ucheba.ru/for-specialists/courses/avtomobilestroenie',
        ],
        186 => [
            'https://www.ucheba.ru/for-specialists/courses/railway',
        ],
        187 => [
            'https://www.ucheba.ru/for-specialists/courses/materialovedenie',
        ],
        188 => [
            'https://www.ucheba.ru/for-specialists/courses/mashinostroenie',
        ],
        189 => [
            'https://www.ucheba.ru/for-specialists/courses/medic-technologies',
        ],
        190 => [
            'https://www.ucheba.ru/for-specialists/courses/morskaya-tehnika',
        ],
        191 => [
            'https://www.ucheba.ru/for-specialists/courses/neftegazovoe-delo',
        ],
        192 => [
            'https://www.ucheba.ru/for-specialists/courses/enterprise-management',
        ],
        193 => [
            'https://www.ucheba.ru/for-specialists/courses/remont-bytovoy-tehniki',
        ],
        194 => [
            'https://www.ucheba.ru/for-specialists/courses/robotics',
        ],
        195 => [
            'https://www.ucheba.ru/for-specialists/courses/telecom',
        ],
        196 => [
            'https://www.ucheba.ru/for-specialists/courses/tehnologii-lyogkoy-promyshlennosti',
        ],
        197 => [
            'https://www.ucheba.ru/for-specialists/courses/tehnologii-pishchevogo-proizvodstva',
        ],
        198 => [
            'https://www.ucheba.ru/for-specialists/courses/tehnologii-poligrafii-i-upakovki',
        ],
        199 => [
            'https://www.ucheba.ru/for-specialists/courses/quality-management',
        ],
        200 => [
            'https://www.ucheba.ru/for-specialists/courses/chemistry-technologies',
        ],
        201 => [
            'https://www.ucheba.ru/for-specialists/courses/elektronika-i-priborostroenie',
        ],
        202 => [
            'https://www.ucheba.ru/for-specialists/courses/it-menedzhment',
            'https://www.ucheba.ru/for-specialists/courses/it-menedzhment?s=30',
        ],
        203 => [
            'https://www.ucheba.ru/for-specialists/courses/government',
            'https://www.ucheba.ru/for-specialists/courses/government?s=30',
            'https://www.ucheba.ru/for-specialists/courses/government?s=60',
        ],
        204 => [
            'https://www.ucheba.ru/for-specialists/courses/logistics',
            'https://www.ucheba.ru/for-specialists/courses/logistics?s=30',
        ],
        205 => [
            'https://www.ucheba.ru/for-specialists/courses/art-management',
        ],
        206 => [
            'https://www.ucheba.ru/for-specialists/courses/medicine-management',
            'https://www.ucheba.ru/for-specialists/courses/medicine-management?s=30',
        ],
        207 => [
            'https://www.ucheba.ru/for-specialists/courses/business-strategy',
            'https://www.ucheba.ru/for-specialists/courses/business-strategy?s=30',
        ],
        208 => [
            'https://www.ucheba.ru/for-specialists/courses/startup',
        ],
        209 => [
            'https://www.ucheba.ru/for-specialists/courses/enterprise-management',
        ],
        210 => [
            'https://www.ucheba.ru/for-specialists/courses/sport-management',
        ],
        211 => [
            'https://www.ucheba.ru/for-specialists/courses/top-management',
        ],
        212 => [
            'https://www.ucheba.ru/for-specialists/courses/team-building',
            'https://www.ucheba.ru/for-specialists/courses/team-building?s=30',
        ],
        213 => [
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education',
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education?s=30',
            'https://www.ucheba.ru/for-specialists/courses/managament-in-education?s=60',
        ],
        214 => [
            'https://www.ucheba.ru/for-specialists/courses/hr-management',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=60',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=90',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=120',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=150',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=180',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=210',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=240',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=270',
            'https://www.ucheba.ru/for-specialists/courses/hr-management?s=300',
        ],
        215 => [
            'https://www.ucheba.ru/for-specialists/courses/project-management',
            'https://www.ucheba.ru/for-specialists/courses/project-management?s=30',
            'https://www.ucheba.ru/for-specialists/courses/project-management?s=60',
            'https://www.ucheba.ru/for-specialists/courses/project-management?s=90',
        ],
        216 => [
            'https://www.ucheba.ru/for-specialists/courses/driving-schools',
        ],
        217 => [
            'https://www.ucheba.ru/for-specialists/courses/pilotage',
        ],
        218 => [
            'https://www.ucheba.ru/for-specialists/courses/astronomy',
        ],
        219 => [
            'https://www.ucheba.ru/for-specialists/courses/matematika',
        ],
        220 => [
            'https://www.ucheba.ru/for-specialists/courses/physics',
        ],
        221 => [
            'https://www.ucheba.ru/for-specialists/courses/linguistics',
        ],
        222 => [
            'https://www.ucheba.ru/for-specialists/courses/literatute',
        ],
        223 => [
            'https://www.ucheba.ru/for-specialists/courses/writing',
        ],
        224 => [
            'https://www.ucheba.ru/for-specialists/courses/perevod-i-perevodovedenie',
        ],
        225 => [
            'https://www.ucheba.ru/for-specialists/courses/russian',
            'https://www.ucheba.ru/for-specialists/courses/russian?s=30',
        ],
        226 => [
            'https://www.ucheba.ru/for-specialists/courses/filologiya',
        ],
        227 => [
            'https://www.ucheba.ru/for-specialists/courses/biology',
        ],
        228 => [
            'https://www.ucheba.ru/for-specialists/courses/chemistry-technologies',
        ],
        229 => [
            'https://www.ucheba.ru/for-specialists/courses/chemistry',
        ],
        230 => [
            'https://www.ucheba.ru/for-specialists/courses/buyers',
            'https://www.ucheba.ru/for-specialists/courses/buyers?s=30',
            'https://www.ucheba.ru/for-specialists/courses/buyers?s=60',
        ],
        231 => [
            'https://www.ucheba.ru/for-specialists/courses/commerce',
            'https://www.ucheba.ru/for-specialists/courses/commerce?s=30',
        ],
        232 => [
            'https://www.ucheba.ru/for-specialists/courses/logistics',
            'https://www.ucheba.ru/for-specialists/courses/logistics?s=30',
        ],
        233 => [
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=30',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=60',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=90',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=120',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=150',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=180',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=210',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=240',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=270',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=300',
            'https://www.ucheba.ru/for-specialists/courses/nalogi-i-buhgalteriya?s=330',
        ],
        234 => [
            'https://www.ucheba.ru/for-specialists/courses/tamozhennoe-delo',
        ],
        235 => [
            'https://www.ucheba.ru/for-specialists/courses/finance',
            'https://www.ucheba.ru/for-specialists/courses/finance?s=30',
            'https://www.ucheba.ru/for-specialists/courses/finance?s=60',
        ],
        236 => [
            'https://www.ucheba.ru/for-specialists/courses/economics',
            'https://www.ucheba.ru/for-specialists/courses/economics?s=30',
        ],
        237 => [
            'https://www.ucheba.ru/for-specialists/courses/mashinostroenie',
        ],
        238 => [
            'https://www.ucheba.ru/for-specialists/courses/neftegazovoe-delo',
        ],
        239 => [
            'https://www.ucheba.ru/for-specialists/courses/enterprise-management',
        ],
        240 => [
            'https://www.ucheba.ru/for-specialists/courses/energetics',
        ],
    ];

    public function configure(): void
    {
        $this->setName('app:kek');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (self::LINKS as $categoryId => $links) {
            /** @var Category $category */
            $category = $this->categoryRepository->find($categoryId);

            foreach ($links as $link) {
                $response = $this->client->request('GET', $link);
                $html = $response->getContent();

                preg_match_all('/<a href="\/program\/(\d+)" class="js_webstat" title="([^"]*)"/', $html, $kek);

                $programNames = $kek[2];

                foreach ($programNames as $programName) {
                    $programs = $this->programRepository->findBy(['name' => $programName]);

                    /** @var Program $program */
                    foreach ($programs as $program) {
                        $program->addCategory($category);
                        $this->entityManager->persist($program);
                    }
                }
            }
        }

        $this->entityManager->flush();

        return 1;
    }
}
