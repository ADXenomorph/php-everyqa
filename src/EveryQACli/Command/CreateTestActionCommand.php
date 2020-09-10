<?php
declare(strict_types=1);

namespace EveryQACli\Command;

use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTestActionCommand extends Command
{
    private EveryQA $everyQa;

    public function __construct(EveryQA $everyQa)
    {
        parent::__construct();

        $this->everyQa = $everyQa;
    }

    protected function configure()
    {
        $this
            ->setName('test:create-action')
            ->setDescription('Create result for selected test')
            ->addArgument('projectId', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('runId', InputArgument::REQUIRED, 'Run ID')
            ->addArgument('testId', InputArgument::REQUIRED, 'Test ID')
            ->addArgument('notes', InputArgument::REQUIRED, 'Result notes')
            ->addArgument('statusId', InputArgument::REQUIRED, 'Status of the result')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('projectId');
        $runId = (int)$input->getArgument('runId');
        $testId = (int)$input->getArgument('testId');
        $notes = $input->getArgument('notes');
        $statusId = (int)$input->getArgument('statusId');

        $run = $this->everyQa->createTestAction($projectId, $runId, $testId, $notes, $statusId);

        $output->writeln($run->__toString());

        return 0;
    }
}
