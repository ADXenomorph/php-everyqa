<?php
declare(strict_types=1);

namespace EveryQACli\Command;

use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCasesCommand extends Command
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
            ->setName('case:get')
            ->setDescription('Get test cases')
            ->addArgument('projectId', InputArgument::REQUIRED, 'Project ID')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('projectId');
        $cases = $this->everyQa->getCases($projectId);

        foreach ($cases as $case) {
            $output->writeln($case->__toString());
        }

        return 0;
    }
}
