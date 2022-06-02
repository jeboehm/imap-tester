<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Factory;

use Service\ImapService;
use Symfony\Component\Console\Input\InputInterface;

class ImapServiceFactory
{
    public static function fromInput(InputInterface $input): ImapService
    {
        return new ImapService(
            $input->getArgument('host'),
            $input->getArgument('port'),
            $input->getArgument('username'),
            $input->getArgument('password')
        );
    }
}
