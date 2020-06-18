<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProviderRequisites
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Provider", inversedBy="providerRequisites")
     */
    private Provider $provider;

    /**
     * @ORM\Column(type="string")
     */
    private string $organizationName;

    /**
     * @ORM\Column(type="string")
     */
    private string $legalAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $mailingAddress;

    /**
     * @ORM\Column(type="string")
     */
    private string $ITN;

    /**
     * @ORM\Column(type="string")
     */
    private string $IEC;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $PSRN;

    /**
     * @ORM\Column(type="string")
     */
    private string $OKPO;

    /**
     * @ORM\Column(type="string")
     */
    private string $checkingAccount;

    /**
     * @ORM\Column(type="string")
     */
    private string $correspondentAccount;

    /**
     * @ORM\Column(type="string")
     */
    private string $BIC;

    /**
     * @ORM\Column(type="string")
     */
    private string $bank;


    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    public function setOrganizationName(string $organizationName): self
    {
        $this->organizationName = $organizationName;
        return $this;
    }

    public function getLegalAddress(): string
    {
        return $this->legalAddress;
    }

    public function setLegalAddress(string $legalAddress): self
    {
        $this->legalAddress = $legalAddress;
        return $this;
    }

    public function getMailingAddress(): string
    {
        return $this->mailingAddress;
    }

    public function setMailingAddress(string $mailingAddress): self
    {
        $this->mailingAddress = $mailingAddress;
        return $this;
    }

    public function getITN(): string
    {
        return $this->ITN;
    }

    public function setITN(string $ITN): self
    {
        $this->ITN = $ITN;
        return $this;
    }

    public function getIEC(): string
    {
        return $this->IEC;
    }

    public function setIEC(string $IEC): self
    {
        $this->IEC = $IEC;
        return $this;
    }

    public function getPSRN(): string
    {
        return $this->PSRN;
    }

    public function setPSRN(string $PSRN): self
    {
        $this->PSRN = $PSRN;
        return $this;
    }

    public function getOKPO(): string
    {
        return $this->OKPO;
    }

    public function setOKPO(string $OKPO): self
    {
        $this->OKPO = $OKPO;
        return $this;
    }

    public function getCheckingAccount(): string
    {
        return $this->checkingAccount;
    }

    public function setCheckingAccount(string $checkingAccount): self
    {
        $this->checkingAccount = $checkingAccount;
        return $this;
    }

    public function getCorrespondentAccount(): string
    {
        return $this->correspondentAccount;
    }

    public function setCorrespondentAccount(string $correspondentAccount): self
    {
        $this->correspondentAccount = $correspondentAccount;
        return $this;
    }

    public function getBIC(): string
    {
        return $this->BIC;
    }

    public function setBIC(string $BIC): self
    {
        $this->BIC = $BIC;
        return $this;
    }

    public function getBank(): string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;
        return $this;
    }
}
