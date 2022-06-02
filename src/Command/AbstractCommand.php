<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Command;

use Factory\ImapServiceFactory;
use Service\ImapService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('host', InputArgument::REQUIRED);
        $this->addArgument('port', InputArgument::REQUIRED);
        $this->addArgument('username', InputArgument::REQUIRED);
        $this->addArgument('password', InputArgument::REQUIRED);
        $this->addArgument('folder', InputArgument::REQUIRED);
    }

    final protected function getImapService(InputInterface $input): ImapService
    {
        return ImapServiceFactory::fromInput($input);
    }
}
