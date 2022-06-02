<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service;

use InvalidArgumentException;
use PhpImap\Mailbox;

class ImapService
{
    private Mailbox $mailbox;

    public function __construct($host, $port, $username, $password, $folder)
    {
        switch ($port) {
            case 143:
                $serverType = 'imap';
                $sslType = 'tls';
                break;
            case 993:
                $serverType = 'imap';
                $sslType = 'ssl';
                break;

            case 110:
                $serverType = 'pop3';
                $sslType = 'tls';
                break;

            case 995:
                $serverType = 'pop3';
                $sslType = 'ssl';
                break;

            default:
                throw new InvalidArgumentException('Port not known');
        }

        $this->mailbox = new Mailbox(
            sprintf(
                '{%s:%s/%s/%s/novalidate-cert}%s',
                $host,
                $port,
                $serverType,
                $sslType,
                $folder
            ),
            $username,
            $password
        );
    }

    public function doCount(): int
    {
        return $this->mailbox->countMails();
    }
}
