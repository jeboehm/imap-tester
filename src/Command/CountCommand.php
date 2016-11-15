<?php

namespace Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('test:count');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->getImapService($input)->doCount();

        $output->writeln($result);

        return 0;
    }
}
