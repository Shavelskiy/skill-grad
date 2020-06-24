<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Result
{
    /**
     * @ORM\Column(type="text")
     */
    protected string $gainedKnowledge;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Certificate")
     */
    protected Certificate $certificate;

    public function getGainedKnowledge(): string
    {
        return $this->gainedKnowledge;
    }

    public function setGainedKnowledge(string $gainedKnowledge): self
    {
        $this->gainedKnowledge = $gainedKnowledge;
        return $this;
    }

    public function getCertificate(): Certificate
    {
        return $this->certificate;
    }

    public function setCertificate(Certificate $certificate): self
    {
        $this->certificate = $certificate;
        return $this;
    }
}
