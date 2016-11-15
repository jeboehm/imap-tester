<?php

namespace Command;

use Factory\ImapServiceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('host', InputArgument::REQUIRED);
        $this->addArgument('port', InputArgument::REQUIRED);
        $this->addArgument('username', InputArgument::REQUIRED);
        $this->addArgument('password', InputArgument::REQUIRED);
        $this->addArgument('folder', InputArgument::REQUIRED);
    }

    final protected function getImapService(InputInterface $input)
    {
        return ImapServiceFactory::fromInput($input);
    }
}
