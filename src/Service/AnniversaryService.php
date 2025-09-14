<?php
namespace NgsHarco\ParticipantAnniversary\Service;

use NgsHarco\ParticipantAnniversary\Event\ParticipantWorkAnniversaryEvent;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AnniversaryService
{
    public function __construct(
        private readonly EntityRepository $participantRepository,
        private readonly EntityRepository $anniversaryLogRepository,
        private readonly ConfigService $config,
        private readonly LoginLinkService $loginLinkService,
        private readonly QrCodeService $qrCodeService,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function processToday(Context $context): int
    {
        $today = new \DateTimeImmutable('today');
        $participants = $this->participantRepository->search(new Criteria(), $context);
        $count = 0;

        foreach ($participants as $participant) {
            $start = $participant->getWorkStartDate();
            if ($start->format('m-d') !== $today->format('m-d')) {
                continue;
            }
            if ($start > $today) {
                continue;
            }
            $end = $participant->getWorkEndDate();
            if ($end && $end < $today) {
                continue;
            }
            $years = $start->diff($today)->y;
            $level = $this->config->findLevelForYears($years);
            if (!$level) {
                continue;
            }

            $criteria = (new Criteria())
                ->addFilter(new EqualsFilter('participantId', $participant->getId()))
                ->addFilter(new EqualsFilter('anniversaryYear', $years));
            $existing = $this->anniversaryLogRepository->search($criteria, $context);
            $alreadySent = false;
            foreach ($existing as $log) {
                if ($log->getSentAt()->format('Y') === $today->format('Y')) {
                    $alreadySent = true;
                    break;
                }
            }
            if ($alreadySent) {
                continue;
            }

            $token = bin2hex(random_bytes(32));
            $expires = $today->modify('+' . $this->config->tokenTtlDays() . ' days');

            $this->anniversaryLogRepository->create([
                [
                    'participantId' => $participant->getId(),
                    'anniversaryYear' => $years,
                    'levelProductId' => $level['productId'] ?? null,
                    'token' => $token,
                    'tokenExpiresAt' => $expires,
                    'sentAt' => new \DateTimeImmutable(),
                ]
            ], $context);

            $link = $this->loginLinkService->build($token);
            $qr = null;
            if ($this->config->generateQrCode()) {
                $qr = $this->qrCodeService->generateDataUri($link, $this->config->qrSize());
            }

            $event = new ParticipantWorkAnniversaryEvent(
                $participant->getId(),
                $participant->getEmail(),
                $participant->getFirstName(),
                $participant->getLastName(),
                $years,
                $level['productId'] ?? null,
                $link,
                $qr,
                $context
            );
            $this->dispatcher->dispatch($event);
            ++$count;
        }

        return $count;
    }
}
