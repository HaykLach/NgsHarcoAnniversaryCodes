<?php
namespace NgsHarco\ParticipantAnniversary\Event\Storer;

use NgsHarco\ParticipantAnniversary\Event\ParticipantWorkAnniversaryEvent;
use Shopware\Core\Framework\Event\FlowEventAware;
use Shopware\Core\Framework\Event\Storer\FlowStorer;
use Shopware\Core\Framework\Event\Storer\FlowStorerPriority;

class ParticipantWorkAnniversaryStorer extends FlowStorer
{
    public function getPriority(): int
    {
        return FlowStorerPriority::DEFAULT;
    }

    public function store(FlowEventAware $event, array $stored): array
    {
        if (!$event instanceof ParticipantWorkAnniversaryEvent) {
            return $stored;
        }

        $stored[ParticipantWorkAnniversaryEvent::NAME] = [
            'participantId' => $event->getParticipantId(),
            'email' => $event->getEmail(),
            'firstName' => $event->getFirstName(),
            'lastName' => $event->getLastName(),
            'anniversaryYear' => $event->getAnniversaryYear(),
            'levelProductId' => $event->getLevelProductId(),
            'loginLink' => $event->getLoginLink(),
            'qrCodeDataUri' => $event->getQrCodeDataUri(),
        ];

        return $stored;
    }

    public function restore(FlowEventAware $event, array $stored): void
    {
        if (!$event instanceof ParticipantWorkAnniversaryEvent) {
            return;
        }

        $data = $stored[ParticipantWorkAnniversaryEvent::NAME] ?? [];
        if ($data) {
            $event->setData($data);
        }
    }
}
