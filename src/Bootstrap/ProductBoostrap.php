<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\TranslationHelper;
use HeyFrame\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
class ProductBoostrap extends AbstractBootstrap
{
    private Connection $connection;

    private TranslationHelper $translationHelper;

    /**
     * @var EntityRepository<ProductCollection>
     */
    private EntityRepository $productRepository;

    public function injectServices(): void
    {
        $this->connection = $this->container->get(Connection::class);
        $this->translationHelper = new TranslationHelper($this->connection);
        $this->productRepository = $this->container->get('product.repository');
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->productRepository->upsert($this->getPayload(), $context);
    }

    public function update(): void
    {
    }

    public function uninstall(bool $keepUserData = false): void
    {
        if ($keepUserData) {
            return;
        }
        $ids = array_map(function ($group) {
            return ['id' => $group['id']];
        }, $this->getPayload());
        $context = $this->installContext->getContext();
        $this->productRepository->delete($ids, $context);
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getPayload(): array
    {
        $fontendChannel = $this->getFrontendChannel();
        $headlessChannel = $this->getHeadlessChannel();

        return [
            [
                'id' => '11dc680240b04f469ccba354cbf0b967',
                'productNumber' => 'SWDEMO10002',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 演示数据',
                    'en-GB' => 'HeyFrame Demo Data',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'media' => [
                    [
                        'id' => '11dc680240b04f469ccba354cbf0b967',
                        'position' => 1,
                        'mediaId' => '11dc680240b04f469ccba354cbf0b967',
                    ],
                ],
                'coverId' => '11dc680240b04f469ccba354cbf0b967',
                'price' => [[
                    'gross' => 950,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'properties' => [
                    [
                        'id' => '2bfd278e87204807a890da4a3e81dd90',
                    ],
                    [
                        'id' => '52454db2adf942b2ac079a296f454a10',
                    ],
                ],
                'visibilities' => [
                    [
                        'id' => '69cd1be4be004944b923ddbe571e96f5',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '01998758dbba732b86f28525b45a482e',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199527b924070a2b8e6614df8e09675',
                'productNumber' => 'SWDEMO10003',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 会员',
                    'en-GB' => 'HeyFrame Membership',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 100,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'properties' => [
                    [
                        'id' => '2bfd278e87204807a890da4a3e81dd90',
                    ],
                    [
                        'id' => '52454db2adf942b2ac079a296f454a10',
                    ],
                ],
                'visibilities' => [
                    [
                        'id' => '0199551657467130990539a57893db48',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '019987590f8972509cdd7a7ab9b02ed5',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199555d62ee701b8fe211a6b96a062c',
                'productNumber' => 'SWDEMO10004',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 积分',
                    'en-GB' => 'HeyFrame Points',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 100,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'properties' => [
                    [
                        'id' => '2bfd278e87204807a890da4a3e81dd90',
                    ],
                    [
                        'id' => '52454db2adf942b2ac079a296f454a10',
                    ],
                ],
                'visibilities' => [
                    [
                        'id' => '0199555f51ff7224a209c22271bd021e',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199875943de73d2807c7da7d0d639e5',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199555fc844736f820726d460521d60',
                'productNumber' => 'SWDEMO10005',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 钱包',
                    'en-GB' => 'HeyFrame Wallet',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 100,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'properties' => [
                    [
                        'id' => '2bfd278e87204807a890da4a3e81dd90',
                    ],
                    [
                        'id' => '52454db2adf942b2ac079a296f454a10',
                    ],
                ],
                'visibilities' => [
                    [
                        'id' => '019955600a9c71bdbc3ccb70932e8ea1',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '01998759705c720a8bab2d9aedcaf6bf',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
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
            throw new \RuntimeException('No channel found, please make sure that basic data is available by running the migrations.');
        }

        return (string)$result;
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
