<?php

namespace App\Entity\Program;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait Iteraction
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramRequest", mappedBy="program")
     */
    protected Collection $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramQuestion", mappedBy="program")
     */
    protected Collection $questions;
}
