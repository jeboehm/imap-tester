<?php

namespace Service;

use InvalidArgumentException;
use PhpImap\Mailbox;

class ImapService
{
    /**
     * @var Mailbox
     */
    private $mailbox;

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

    public function doCount()
    {
        return $this->mailbox->countMails();
    }
}
