<?php

namespace App\Entity\Content\Seo;

use App\Entity\Program\Program;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProgramSeo extends AbstractSeo
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Program\Program", inversedBy="seo")
     */
    protected Program $program;

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        $this->program = $program;
        return $this;
    }
}
