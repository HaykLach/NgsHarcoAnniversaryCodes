<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\Participant;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ParticipantEntity extends Entity
{
    use EntityIdTrait;

    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected \DateTimeInterface $workStartDate;
    protected ?\DateTimeInterface $workEndDate;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getWorkStartDate(): \DateTimeInterface
    {
        return $this->workStartDate;
    }

    public function setWorkStartDate(\DateTimeInterface $date): void
    {
        $this->workStartDate = $date;
    }

    public function getWorkEndDate(): ?\DateTimeInterface
    {
        return $this->workEndDate;
    }

    public function setWorkEndDate(?\DateTimeInterface $date): void
    {
        $this->workEndDate = $date;
    }
}
