<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoveCommand extends AbstractCommand
{
    protected function configure(): void
    {
        parent::configure();

        $this->setName('test:move');
        $this->addArgument('messageIndex', InputArgument::REQUIRED);
        $this->addArgument('targetFolder', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->getImapService($input)->doMove(
            $input->getArgument('folder'),
            (int) $input->getArgument('messageIndex'),
            $input->getArgument('targetFolder')
        );

        if ($result) {
            $output->writeln('Mail was successfully moved.');

            return 0;
        }

        $output->writeln('Cannot move mail');

        return 1;
    }
}
