<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\TranslationHelper;
use HeyFrame\Core\Content\Navigation\NavigationCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Api\Context\SystemSource;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Channel\ChannelCollection;

/**
 * @internal
 */
class NavigationBootstrap extends AbstractBootstrap
{
    /**
     * @var EntityRepository<NavigationCollection>
     */
    private EntityRepository $navigationRepository;

    /**
     * @var EntityRepository<ChannelCollection>
     */
    private EntityRepository $channelRepository;

    private Connection $connection;

    private TranslationHelper $translationHelper;

    public function injectServices(): void
    {
        $this->connection = $this->container->get(Connection::class);
        $this->navigationRepository = $this->container->get('navigation.repository');
        $this->channelRepository = $this->container->get('channel.repository');
        $this->translationHelper = new TranslationHelper($this->connection);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getPayload(): array
    {
        $cmsPageId = $this->getDefaultCmsListingPageId();

        return [
            [
                'id' => $this->getRootNavigationId(),
                //                'cmsPageId' => '695477e02ef643e5a016b83ed4cdf63a',
                'active' => true,
                'visible' => true,
                'type' => 'page',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'HeyFrame ｜ 极速开发，快速构建全栈应用',
                    'en-GB' => 'HeyFrame ｜ Fast development, build full-stack apps in no time',
                ]),
                'children' => [
                    [
                        'id' => '77b959cf66de4c1590c7f9b7da3982f3',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => true,
                        'type' => 'page',
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '插件',
                            'en-GB' => 'Plugins',
                        ]),
                    ],
                    [
                        'id' => '019998d56bb070b3a54a492c20873c05',
                        'afterNavigationId' => '77b959cf66de4c1590c7f9b7da3982f3',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => true,
                        'type' => 'page',
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '主题',
                            'en-GB' => ' Themes',
                        ]),
                    ],
                    [
                        'id' => 'a515ae260223466f8e37471d279e6406',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => true,
                        'type' => 'page',
                        'afterNavigationId' => '019998d56bb070b3a54a492c20873c05',
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '演示',
                            'en-GB' => 'Demos',
                        ]),
                    ],
                    [
                        'id' => '01969ba7567770ccb426156302a1c187',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => true,
                        'type' => 'page',
                        'afterNavigationId' => 'a515ae260223466f8e37471d279e6406',
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '下载',
                            'en-GB' => 'Downloads',
                        ]),
                    ],
                    [
                        'id' => '01942ce041de71cfbb175364b166dd4d',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => false,
                        'type' => 'page',
                        'afterNavigationId' => '01969ba7567770ccb426156302a1c187',
                        'footerChannels' => [
                            [
                                'id' => $this->getFrontendChannel(),
                            ],
                        ],
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '页脚导航',
                            'en-GB' => 'Footer navigation',
                        ]),
                        'children' => [
                            [
                                'id' => '01969bc7d51872cbb9c0a08ebcef82db',
                                'cmsPageId' => $cmsPageId,
                                'active' => true,
                                'visible' => true,
                                'type' => 'page',
                                'name' => $this->translationHelper->adjustTranslations([
                                    'zh-CN' => '帮助与支持',
                                    'en-GB' => 'Help & Support',
                                ]),
                                'children' => [
                                    [
                                        'id' => '01969c92918271a0ac79a4f9a96755ea',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '购物指南',
                                            'en-GB' => 'Shopping Guide',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c936fdf732f863b4748bd163ade',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c92918271a0ac79a4f9a96755ea',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '支付方式',
                                            'en-GB' => 'Payment Methods',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c93c80b70bbaadd3a1c4372ba37',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c936fdf732f863b4748bd163ade',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '配送与物流',
                                            'en-GB' => 'Shipping & Delivery',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c94256072bda4eb4d1cd30413f3',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c93c80b70bbaadd3a1c4372ba37',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '售后服务',
                                            'en-GB' => 'After-Sales Service',
                                        ]),
                                    ],
                                ],
                            ],
                            [
                                'id' => '01969bcb75b2715a81162a8aff0214a8',
                                'cmsPageId' => $cmsPageId,
                                'active' => true,
                                'visible' => true,
                                'type' => 'page',
                                'afterNavigationId' => '01969bc7d51872cbb9c0a08ebcef82db',
                                'name' => $this->translationHelper->adjustTranslations([
                                    'zh-CN' => '产品分类',
                                    'en-GB' => 'Product Categories',
                                ]),
                                'children' => [
                                    [
                                        'id' => '01969c9676097247ab2d06d8594e2814',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c93c80b70bbaadd3a1c4372ba37',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '热卖产品',
                                            'en-GB' => 'Hot Sale Products',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c96c7b97111921516d53e9fd217',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c9676097247ab2d06d8594e2814',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '限时抢购',
                                            'en-GB' => 'Limited Time Offers',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c974987738b8635350a37c32de7',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c96c7b97111921516d53e9fd217',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '新品上市',
                                            'en-GB' => 'New Arrivals',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c97b78171948d6e471634360e07',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c974987738b8635350a37c32de7',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '优惠产品',
                                            'en-GB' => 'Discounted Products',
                                        ]),
                                    ],
                                    [
                                        'id' => '01969c982388709aa5aa394ff8559436',
                                        'cmsPageId' => $cmsPageId,
                                        'active' => true,
                                        'visible' => true,
                                        'type' => 'page',
                                        'afterNavigationId' => '01969c97b78171948d6e471634360e07',
                                        'name' => $this->translationHelper->adjustTranslations([
                                            'zh-CN' => '清仓特卖',
                                            'en-GB' => 'Clearance Sale',
                                        ]),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => '01942cf93310710d9faf4a4d76e05a9c',
                        'cmsPageId' => $cmsPageId,
                        'active' => true,
                        'visible' => false,
                        'type' => 'page',
                        'afterNavigationId' => '01942ce041de71cfbb175364b166dd4d',
                        'name' => $this->translationHelper->adjustTranslations([
                            'zh-CN' => '页脚服务导航',
                            'en-GB' => 'Footer service navigation',
                        ]),
                        'serviceChannels' => [
                            [
                                'id' => $this->getFrontendChannel(),
                            ],
                        ],
                        'children' => [
                            [
                                'id' => '01942cf99e0e713ea31d4fdfe5b385bd',
                                'cmsPageId' => $cmsPageId,
                                'active' => true,
                                'visible' => true,
                                'type' => 'page',
                                'name' => $this->translationHelper->adjustTranslations([
                                    'zh-CN' => '条款与条件',
                                    'en-GB' => 'Terms & Conditions',
                                ]),
                            ],
                            [
                                'id' => '01942cfb468c735293b76d34314c909e',
                                'cmsPageId' => $cmsPageId,
                                'active' => true,
                                'visible' => true,
                                'type' => 'page',
                                'afterNavigationId' => '01942cf99e0e713ea31d4fdfe5b385bd',
                                'name' => $this->translationHelper->adjustTranslations([
                                    'zh-CN' => '隐私协议',
                                    'en-GB' => 'Privacy',
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->navigationRepository->upsert($this->getPayload(), $context);
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
        $this->navigationRepository->upsert([
            [
                'id' => $this->getRootNavigationId(),
                'cmsPageId' => null,
            ],
        ], $context);

        $this->channelRepository->upsert([
            [
                'id' => $this->getFrontendChannel(),
                'footerNavigationId' => null,
                'serviceNavigationId' => null,
            ],
        ], $context);

        $this->deleteOnlyChildren($this->getRootNavigationId(), $context);
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
    }

    public function deleteOnlyChildren(string $parentNavigationId, Context $context): void
    {
        $childIds = $this->getAllChildNavigationIds($parentNavigationId, $context);

        if (\count($childIds) === 0) {
            return;
        }

        $deletePayload = array_map(fn ($id) => ['id' => $id], $childIds);

        $this->navigationRepository->delete($deletePayload, $context);
    }

    /**
     * @return list<string>
     */
    private function getAllChildNavigationIds(string $parentId, Context $context): array
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('parentId', $parentId));
        $criteria->addAssociation('children');

        $children = $this->navigationRepository->search($criteria, $context)->getEntities();

        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->getId();
            $ids = array_merge($ids, $this->getAllChildNavigationIds($child->getId(), $context));
        }

        return $ids;
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

    private function getRootNavigationId(): string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('parentId', null));

        $rootNavigation = $this->navigationRepository->search($criteria, new Context(new SystemSource()))->getEntities()->first();
        if ($rootNavigation === null) {
            throw new \RuntimeException('Root navigation not found');
        }

        return $rootNavigation->getId();
    }

    private function getDefaultCmsListingPageId(): string
    {
        $id = $this->getCmsPageIdByName('Default listing layout');

        if ($id !== null) {
            return $id;
        }

        // BC support for older shopware versions - \Shopware\Core\Migration\V6_4\Migration1645019769UpdateCmsPageTranslation changed the translations
        $id = $this->getCmsPageIdByName('默认列表布局');

        if ($id !== null) {
            return $id;
        }

        throw new \RuntimeException('Default Cms Listing page not found');
    }

    private function getCmsPageIdByName(string $name): ?string
    {
        $id = $this->connection->fetchOne(
            '
                SELECT LOWER(HEX(cms_page_id)) as cms_page_id
                FROM cms_page_translation
                INNER JOIN cms_page ON cms_page.id = cms_page_translation.cms_page_id
                WHERE cms_page.locked
                AND name = :name
            ',
            ['name' => $name],
        );

        return $id !== false ? $id : null;
    }
}
