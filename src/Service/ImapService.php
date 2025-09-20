<?php

declare(strict_types=1);
/**
 * This file is part of the imap-tester package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service;

class ImapService
{
    /** @var \Horde_Imap_Client_Socket_Pop3|\Horde_Imap_Client_Socket */
    private \Horde_Imap_Client_Base $client;

    public function __construct($host, $port, $username, $password, $protocol, $sslType)
    {
        $options = [
            'username' => $username,
            'password' => $password,
            'hostspec' => $host,
            'port' => $port,
            'secure' => $sslType,
        ];

        if ('pop3' === $protocol) {
            $this->client = new \Horde_Imap_Client_Socket_Pop3($options);
        } else {
            $this->client = new \Horde_Imap_Client_Socket($options);
        }
    }

    public function doCount(string $folder): int
    {
        $results = $this->client->search($folder)['match'];

        return is_countable($results) ? count($results) : 0;
    }

    public function doMove(string $folder, int $messageIndex, string $targetFolder): bool
    {
        $mails = $this->client->search($folder)['match'];

        if (!array_key_exists($messageIndex, $mails->ids)) {
            throw new \RuntimeException('Mail was not found.');
        }

        $countBefore = $this->doCount($folder);
        $this->client->copy($folder, $targetFolder, [
            'ids' => new \Horde_Imap_Client_Ids($mails->ids[$messageIndex]),
            'move' => true,
        ]);
        $this->client->close();

        return $this->doCount($folder) !== $countBefore;
    }
}
