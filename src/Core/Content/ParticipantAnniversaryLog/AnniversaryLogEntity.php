<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\ParticipantAnniversaryLog;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class AnniversaryLogEntity extends Entity
{
    use EntityIdTrait;

    protected string $participantId;
    protected int $anniversaryYear;
    protected ?string $levelProductId;
    protected string $token;
    protected \DateTimeInterface $tokenExpiresAt;
    protected ?\DateTimeInterface $usedAt;
    protected \DateTimeInterface $sentAt;

    public function getParticipantId(): string
    {
        return $this->participantId;
    }

    public function setParticipantId(string $participantId): void
    {
        $this->participantId = $participantId;
    }

    public function getAnniversaryYear(): int
    {
        return $this->anniversaryYear;
    }

    public function setAnniversaryYear(int $year): void
    {
        $this->anniversaryYear = $year;
    }

    public function getLevelProductId(): ?string
    {
        return $this->levelProductId;
    }

    public function setLevelProductId(?string $id): void
    {
        $this->levelProductId = $id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getTokenExpiresAt(): \DateTimeInterface
    {
        return $this->tokenExpiresAt;
    }

    public function setTokenExpiresAt(\DateTimeInterface $expires): void
    {
        $this->tokenExpiresAt = $expires;
    }

    public function getUsedAt(): ?\DateTimeInterface
    {
        return $this->usedAt;
    }

    public function setUsedAt(?\DateTimeInterface $usedAt): void
    {
        $this->usedAt = $usedAt;
    }

    public function getSentAt(): \DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): void
    {
        $this->sentAt = $sentAt;
    }
}
