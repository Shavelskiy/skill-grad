<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Iteraction
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramRequest", mappedBy="program")
     */
    private array $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramQuestion", mappedBy="program")
     */
    private array $questions;
}
