<?php

namespace Factory;

use Service\ImapService;
use Symfony\Component\Console\Input\InputInterface;

class ImapServiceFactory
{
    public static function fromInput(InputInterface $input)
    {
        return new ImapService(
            $input->getArgument('host'),
            $input->getArgument('port'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('folder')
        );
    }
}
