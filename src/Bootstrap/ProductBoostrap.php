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

        return [
            [
                'id' => '11dc680240b04f469ccba354cbf0b967',
                'productNumber' => 'SWDEMO10002',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 系统演示数据',
                    'en-GB' => 'HeyFrame Demo Data',
                ]),
                'categories' => [
                    [
                        'id' => '77b959cf66de4c1590c7f9b7da3982f3',
                    ],
                ],
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
                ],
            ],
            [
                'id' => '0199527b924070a2b8e6614df8e09675',
                'productNumber' => 'SWDEMO10003',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame 系统演示数据',
                    'en-GB' => 'Membership',
                ]),
                'categories' => [
                    [
                        'id' => '77b959cf66de4c1590c7f9b7da3982f3',
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
            throw new \RuntimeException('No tax found, please make sure that basic data is available by running the migrations.');
        }

        return (string) $result;
    }
}
