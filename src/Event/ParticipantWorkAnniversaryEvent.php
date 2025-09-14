<?php
namespace NgsHarco\ParticipantAnniversary\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\FlowEventAware;
use Shopware\Core\Framework\Event\StorableFlowEvent;

class ParticipantWorkAnniversaryEvent extends StorableFlowEvent implements FlowEventAware
{
    public const NAME = 'ngs_harco.participant.work_anniversary';

    public function __construct(
        private readonly string $participantId,
        private readonly string $email,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly int $anniversaryYear,
        private readonly ?string $levelProductId,
        private readonly string $loginLink,
        private readonly ?string $qrCodeDataUri,
        Context $context
    ) {
        parent::__construct($context);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getParticipantId(): string
    {
        return $this->participantId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAnniversaryYear(): int
    {
        return $this->anniversaryYear;
    }

    public function getLevelProductId(): ?string
    {
        return $this->levelProductId;
    }

    public function getLoginLink(): string
    {
        return $this->loginLink;
    }

    public function getQrCodeDataUri(): ?string
    {
        return $this->qrCodeDataUri;
    }
}
