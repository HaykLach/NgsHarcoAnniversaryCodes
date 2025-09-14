<?php
namespace NgsHarco\ParticipantAnniversary\Controller\Admin;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantImportController
{
    public function __construct(private readonly EntityRepository $participantRepository)
    {
    }

    #[Route(path: '/_action/ngs-harco/participants/import', name: 'ngs-harco.participants.import', methods: ['POST'])]
    public function import(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }
        $handle = fopen($file->getPathname(), 'r');
        $headers = fgetcsv($handle);
        $required = ['first_name','last_name','email','work_start_date'];
        if (array_diff($required, $headers)) {
            return new JsonResponse(['error' => 'Missing headers'], 400);
        }
        $created = $updated = 0; $failed = [];
        $line = 1;
        while (($row = fgetcsv($handle)) !== false) {
            $line++;
            $data = array_combine($headers, $row);
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $failed[] = ['line' => $line, 'reason' => 'Invalid email'];
                continue;
            }
            $start = \DateTime::createFromFormat('Y-m-d', $data['work_start_date']);
            if (!$start) {
                $failed[] = ['line' => $line, 'reason' => 'Invalid start date'];
                continue;
            }
            $context = Context::createDefaultContext();
            $existing = $this->participantRepository->search((new Criteria())
                ->addFilter(new EqualsFilter('email', $data['email'])), $context);
            $payload = [
                'firstName' => $data['first_name'],
                'lastName' => $data['last_name'],
                'email' => $data['email'],
                'workStartDate' => $data['work_start_date'],
                'workEndDate' => $data['work_end_date'] ?: null,
            ];
            if ($existing->first()) {
                $payload['id'] = $existing->first()->getId();
                $this->participantRepository->update([$payload], $context);
                $updated++;
            } else {
                $payload['id'] = Uuid::randomHex();
                $this->participantRepository->create([$payload], $context);
                $created++;
            }
        }
        fclose($handle);
        return new JsonResponse(['created' => $created, 'updated' => $updated, 'failed' => $failed]);
    }
}
