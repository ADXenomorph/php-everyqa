<?php
declare(strict_types=1);

namespace EveryQACli\Command;

use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCurrentUserCommand extends Command
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
            ->setName('user:current')
            ->setDescription('Get current user info');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->everyQa->getCurrentUser();
        $output->writeln(sprintf('Current user: %s', $user->__toString()));

        return 0;
    }
}
