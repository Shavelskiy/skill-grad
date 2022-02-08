<?php

namespace App\Entity\Service;

use App\Entity\Program\Program;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;

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

    public function getTitle(): string
    {
        if ($this->getType() === self::HIGHLIGHT) {
            return sprintf('Выделение программы "%s" на 30 дней', $this->getProgram()->getName());
        }

        if ($this->getType() === self::RAISE) {
            return sprintf('Однократное поднятие программы "%s" в результатах поиска', $this->getProgram()->getName());
        }

        if ($this->getType() === self::HIGHLIGHT_RISE) {
            return sprintf('Выделение цветом на 30 дней и однократное поднятие в результах поиска программы "%s"', $this->getProgram()->getName());
        }

        throw new RuntimeException('service type is not available');
    }

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
