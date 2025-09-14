<?php
namespace NgsHarco\ParticipantAnniversary\Command;

use NgsHarco\ParticipantAnniversary\Service\AnniversaryService;
use Shopware\Core\Framework\Context;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'ngs-harco:participants:check-anniversaries')]
class CheckAnniversariesCommand extends Command
{
    public function __construct(private readonly AnniversaryService $service)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $this->service->processToday(Context::createDefaultContext());
        $output->writeln(sprintf('Processed %d anniversaries', $count));
        return self::SUCCESS;
    }
}
