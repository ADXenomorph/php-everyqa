<?php
declare(strict_types=1);

namespace EveryQACli\Command;

use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRunCommand extends Command
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
            ->setName('run:create')
            ->setDescription('Create test run')
            ->addArgument('projectId', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('assignTo', InputArgument::REQUIRED, 'User to assign test run to')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the test run')
            ->addArgument('sprintId', InputArgument::REQUIRED, 'Sprint ID to create test run in')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('projectId');
        $assignTo = $input->getArgument('assignTo');
        $name = $input->getArgument('name');
        $sprintId = $input->getArgument('sprintId');
        $run = $this->everyQa->createRun($projectId, $assignTo, $name, $sprintId);

        $output->writeln($run->__toString());

        return 0;
    }
}
