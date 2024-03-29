<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountCommand extends AbstractCommand
{
    protected function configure(): void
    {
        parent::configure();

        $this->setName('test:count');
        $this->setDescription('Count messages in a folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->getImapService($input)->doCount(
            $input->getArgument('folder')
        );

        $output->writeln($result);

        return 0;
    }
}
