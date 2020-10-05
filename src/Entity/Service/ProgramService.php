<?php

namespace App\Entity\Service;

use App\Entity\Program\Program;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProgramService extends AbstractService
{
    public const HIGHLIGHT = 'highlight';
    public const RAISE = 'raise';
    public const HIGHLIGHT_RISE = 'highlight_raise';

    public const TYPES = [
        self::HIGHLIGHT,
        self::RAISE,
        self::HIGHLIGHT_RISE,
    ];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="services")
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
