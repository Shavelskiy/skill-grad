<?php

namespace App\Messenger;

use App\Adapter\RedisClient;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected $clients;

    protected $logger;
    protected $em;

    protected const MSG_INIT = 'init';

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->clients = new SplObjectStorage();
        $this->logger = $logger;
        $this->em = $em;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
        $this->logger->alert(sprintf('new socket connection %s', $conn->resourceId));
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msgStr
     */
    public function onMessage(ConnectionInterface $from, $msgStr): void
    {
        $msg = json_decode($msgStr, true);

        if ($msg['type'] === self::MSG_INIT) {
            try {
                $userRepository = $this->em->getRepository(User::class);
                $user = $userRepository->findByChatToken($msg['token']);

                $idKey = $this->getUserIdKey($user->getId());
                $pIdKey = $this->getUserPIdKey($from->resourceId);

                $redis = RedisClient::getConnection();
                $pIds = unserialize($redis->get($idKey));
                if ($pIds === false) {
                    $pIds = [];
                }

                $pIds[] = $from->resourceId;
                $redis->set($idKey, serialize($pIds));
                $redis->set($pIdKey, $user->getId());

                $from->send('success');
            } catch (Exception $e) {
                $from->send('error');
            }

            return;
        }

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $this->clients->detach($conn);
        $this->logger->alert(sprintf('destroy socket connection %s', $conn->resourceId));
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $this->logger->alert(sprintf('socket connection %s, error %s', $conn->resourceId, $e->getMessage()));
        $conn->close();
    }

    protected function deleteUserFromStorage($pId): void
    {
        $redis = RedisClient::getConnection();

        $pIdKey = $this->getUserPIdKey($pId);
        $userId = $redis->get($pIdKey);
        $userIdKey = $this->getUserIdKey($userId);

        $pIds = unserialize($redis->get($userIdKey));

        foreach ($pIds as $key => $curPId) {
            if ($curPId === $pId) {
                unset($pIds[$key]);
            }
        }

        if (!empty($pIds)) {
            $redis->set($userIdKey, serialize($pIds));
        } else {
            $redis->del($userIdKey);
        }

        $redis->del($pIdKey);
    }

    protected function getUserIdKey($userId): string
    {
        return sprintf('user.chat.id.%s', $userId);
    }

    protected function getUserPIdKey($pid): string
    {
        return sprintf('user.chat.pid.%s', $pid);
    }
}
