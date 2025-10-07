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
class ProductBootstrap extends AbstractBootstrap
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
            [
                'id' => '0199a54ccb1373ef8dadaa5e80d271b1',
                'productNumber' => 'HYDEMO100050167',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'Uniapp 开发模版',
                    'en-GB' => 'Uniapp develop template',
                ]),
                'media' => [
                    [
                        'id' => '0199a54ccb1373ef8dadaa5e80d271b1',
                        'position' => 1,
                        'mediaId' => '0199a54ccb1373ef8dadaa5e80d271b1',
                    ],
                ],
                'coverId' => '0199a54ccb1373ef8dadaa5e80d271b1',
                'categories' => [
                    [
                        'id' => '019987277ecc7313adca2244ba00150d',
                    ],
                ],
                'price' => [[
                    'gross' => 699,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199a54d57de70a191eb28e000c19cba',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199a54d6982709b92953a491fd3aff7',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b35f066b727580a20e372242a142',
                'productNumber' => 'HYSWDEMO100035004481',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '聚合支付',
                    'en-GB' => 'Payment',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 999.99,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c83d61723ab5ecc676d3db6209',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b35f066b727580a20e372242a142',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b363f7eb73ea96f2090ec8861526',
                'productNumber' => 'HYSWDEMO100035004482',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '营销 - 优惠卷、活动',
                    'en-GB' => 'Marketing, Coupons & Promotions',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 100.99,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c822f672c6bf87db8797e6f4c9',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b363f7eb73ea96f2090ec8861526',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b365c4b3732396a201a49fb8eab5',
                'productNumber' => 'HYSWDEMO100035004483',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '客户身份登录',
                    'en-GB' => 'Login as Customer',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 99.66,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c80ee170258958d15cad94e7a4',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b365c4b3732396a201a49fb8eab5',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b3682dc672cba8ab8bd78327e613',
                'productNumber' => 'HYSWDEMO100035004484',
                'active' => true,
                'stock' => 10,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '云存储',
                    'en-GB' => 'Cloud Storage',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 88.88,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c7f7e473a7a9c457a7ba83eb77',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b3682dc672cba8ab8bd78327e613',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b36be2b77259a72ebf67845ca4c8',
                'productNumber' => 'HYSWDEMO100035004485',
                'active' => true,
                'stock' => 100,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '社交账号登录',
                    'en-GB' => 'Login with Social Account',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 66,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c7dc127305b45ce7b324cbd572',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b36be2b77259a72ebf67845ca4c8',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b36e20c8719d842eae59ff95408b',
                'productNumber' => 'HYSWDEMO100035004486',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '销售统计',
                    'en-GB' => 'Sales Statistics',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 688,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c7c2627018af4eca77e8458647',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b36e20c8719d842eae59ff95408b',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b36f8bbe72a0925f41d601ffd9b1',
                'productNumber' => 'HYSWDEMO100035004487',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '产品关联销售',
                    'en-GB' => 'Cross-Selling',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 4899,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c7a6eb72a890159df45ae4c74a',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b36f8bbe72a0925f41d601ffd9b1',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b3729b3270e6814a802371089892',
                'productNumber' => 'HYSWDEMO100035004488',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'CMS 扩展',
                    'en-GB' => 'CMS Extension',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 500,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b3729b3270e6814a802371089892',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b4c78ac473f1bddba4db41946b93',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b377313c7388be973db263d5c7d9',
                'productNumber' => 'HYSWDEMO100035004489',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '系统工具',
                    'en-GB' => 'System Tools',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 29.9,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b377313c7388be973db263d5c7d9',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b4c77348730195d5cf34e647b817',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b378412271dabcccfe59503d8873',
                'productNumber' => 'HYSWDEMO100035004490',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '主题模版在线编辑器',
                    'en-GB' => 'Online Theme Template Editor',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 109.99,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c72a2173c2a00cceb76df8e391',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b4c73e2170dca570cd8a59f47fa2',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b379822971f79ad6187191f4c289',
                'productNumber' => 'HYSWDEMO100035004491',
                'active' => true,
                'stock' => 9999,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '博客',
                    'en-GB' => 'Blog',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 209.99,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c6fba171ec834a8d0ae501fe80',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b4c70f1c718584dc5683f76bc28a',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199b37b4a38714abf2ddeb635fa6134',
                'productNumber' => 'HYSWDEMO100035004492',
                'active' => true,
                'stock' => 6000,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '问答社区',
                    'en-GB' => 'Q&A Community',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 1209.99,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199b4c5a9cc7222b531808c03bdd948',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199b4c5bef3726ea66012681a9de605',
                        'channelId' => $headlessChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
            [
                'id' => '0199badc8c09702bb13c2a31a1fcacd8',
                'productNumber' => 'HYSWDEMO100035004494',
                'active' => true,
                'stock' => 6000,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '任务、悬赏',
                    'en-GB' => 'Tasks & Rewards',
                ]),
                'categories' => [
                    [
                        'id' => '01998723f6187075b5cb80b9f517037a',
                    ],
                ],
                'price' => [[
                    'gross' => 2000,
                    'currencyId' => Defaults::CURRENCY,
                ]],
                'visibilities' => [
                    [
                        'id' => '0199badcabec70399f954bf4116bdbf1',
                        'channelId' => $fontendChannel,
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                    [
                        'id' => '0199badc8c09702bb13c2a31a1fcacd8',
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

        return (string) $result;
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

        return (string) $result;
    }
}
