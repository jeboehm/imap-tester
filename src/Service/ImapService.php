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
use RuntimeException;

class ImapService
{
    private Mailbox $mailbox;

    public function __construct($host, $port, $username, $password)
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
                '{%s:%s/%s/%s/novalidate-cert}',
                $host,
                $port,
                $serverType,
                $sslType,
            ),
            $username,
            $password
        );

        $this->mailbox->setConnectionArgs(CL_EXPUNGE);
    }

    public function doCount(string $folder): int
    {
        $this->mailbox->switchMailbox($folder);

        return $this->mailbox->countMails();
    }

    public function doMove(string $folder, int $messageIndex, string $targetFolder): bool
    {
        $this->mailbox->switchMailbox($folder);
        $mailsIds = $this->mailbox->searchMailbox();

        if (!array_key_exists($messageIndex, $mailsIds)) {
            throw new RuntimeException('Mail was not found.');
        }

        $countBefore = $this->doCount($folder);
        $this->mailbox->moveMail($mailsIds[0], $targetFolder);

        return $this->doCount($folder) !== $countBefore;
    }
}
