<?php
declare(strict_types=1);

namespace EveryQACli\Command;

use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTestCommand extends Command
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
            ->setName('test:create')
            ->setDescription('Create test for selected test case')
            ->addArgument('projectId', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('runId', InputArgument::REQUIRED, 'Run ID')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('projectId');
        $runId = (int)$input->getArgument('runId');

        $run = $this->everyQa->createTest($projectId, $runId);

        $output->writeln($run->__toString());

        return 0;
    }
}
