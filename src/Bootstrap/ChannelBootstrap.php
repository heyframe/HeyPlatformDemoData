<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Api\Util\AccessKeyHelper;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Channel\ChannelCollection;

class ChannelBootstrap extends AbstractBootstrap
{
    final public const ACCESS_KEY = 'SWSCEGPJS0LVTMPRCVBZS2WYBA';

    private Connection $connection;

    /**
     * @var EntityRepository<ChannelCollection>
     */
    private EntityRepository $channelRepository;

    public function injectServices(): void
    {
        $this->channelRepository = $this->container->get('channel.repository');
        $this->connection = $this->container->get(Connection::class);
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->channelRepository->upsert([
            [
                'id' => $this->getHeadlessChannel(),
                'accessKey' => self::ACCESS_KEY,
            ],
        ], $context);
    }

    public function update(): void
    {
        // TODO: Implement update() method.
    }

    public function uninstall(bool $keepUserData = false): void
    {
        if ($keepUserData) {
            return;
        }
        $context = $this->installContext->getContext();
        $this->channelRepository->upsert([
            [
                'id' => $this->getHeadlessChannel(),
                'accessKey' => AccessKeyHelper::generateAccessKey('channel'),
            ],
        ], $context);
    }

    public function activate(): void
    {
        // TODO: Implement activate() method.
    }

    public function deactivate(): void
    {
        // TODO: Implement deactivate() method.
    }

    private function getHeadlessChannel(): string
    {
        $result = $this->connection->fetchOne('
            SELECT LOWER(HEX(`id`))
            FROM `channel`
            WHERE `type_id` = :fontend_type
        ', ['fontend_type' => Uuid::fromHexToBytes(Defaults::CHANNEL_TYPE_API)]);

        if ($result === false) {
            throw new \RuntimeException('No channel found, please make sure that basic data is available by running the migrations.');
        }

        return (string)$result;
    }
}
