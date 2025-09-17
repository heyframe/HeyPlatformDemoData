<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\TranslationHelper;
use HeyFrame\Core\Checkout\Promotion\Aggregate\PromotionChannel\PromotionChannelCollection;
use HeyFrame\Core\Checkout\Promotion\PromotionCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
class PromotionBoostrap extends AbstractBootstrap
{
    private Connection $connection;

    private TranslationHelper $translationHelper;

    /**
     * @var EntityRepository<PromotionCollection>
     */
    private EntityRepository $promotionRepository;

    /**
     * @var EntityRepository<PromotionChannelCollection>
     */
    private EntityRepository $promotionChannelRepository;

    public function injectServices(): void
    {
        $this->connection = $this->container->get(Connection::class);
        $this->translationHelper = new TranslationHelper($this->connection);
        $this->promotionRepository = $this->container->get('promotion.repository');
        $this->promotionChannelRepository = $this->container->get('promotion_channel.repository');
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->promotionRepository->upsert($this->getPayload(), $context);
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

        // 获取 promotion ID 数组
        $promotionIds = array_map(fn ($group) => $group['id'], $this->getPayload());

        if (empty($promotionIds)) {
            return;
        }

        // 先删除 promotion_channel 关联表数据
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsAnyFilter('promotionId', $promotionIds));

        $promotionChannelIds = $this->promotionChannelRepository->searchIds($criteria, $context);

        $channelIds = array_map(fn ($id) => ['id' => $id], $promotionChannelIds->getIds());
        if (!empty($channelIds)) {
            $this->promotionChannelRepository->delete($channelIds, $context);
        }

        // 再删除 promotion 主表数据
        $promotionData = array_map(fn ($id) => ['id' => $id], $promotionIds);
        $this->promotionRepository->delete($promotionData, $context);
    }

    public function activate(): void
    {
        // TODO: Implement activate() method.
    }

    public function deactivate(): void
    {
        // TODO: Implement deactivate() method.
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getPayload(): array
    {
        return [
            [
                'id' => '01942d4fa1d57397aca1a47ad887f401',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '促销-1',
                    'en-GB' => 'promotion-1',
                ]),
                'active' => true,
                'validFrom' => new \DateTime(),
                'validUntil' => (new \DateTime())->add(new \DateInterval('P365D')),
                'code' => '100000000000',
                'channels' => [
                    [
                        'id' => '01969fa0ce3b7612a136b7b0b7f9f6fe',
                        'priority' => 1,
                        'channelId' => $this->getFrontendChannel(),
                    ],
                ],
                'useCodes' => true,
            ],
        ];
    }

    private function getFrontendChannel(): string
    {
        $result = $this->connection->fetchOne('
            SELECT LOWER(HEX(`id`))
            FROM `channel`
            WHERE `type_id` = :fontend_type
        ', ['fontend_type' => Uuid::fromHexToBytes(Defaults::CHANNEL_TYPE_FRONTEND)]);

        if ($result === false) {
            throw new \RuntimeException('No tax found, please make sure that basic data is available by running the migrations.');
        }

        return (string) $result;
    }
}
