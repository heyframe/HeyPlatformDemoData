<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\TranslationHelper;
use HeyFrame\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupCollection;
use HeyFrame\Core\Checkout\Customer\CustomerCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\Test\TestDefaults;

/**
 * @internal
 */
class CustomerBoostrap extends AbstractBootstrap
{
    private TranslationHelper $translationHelper;

    private Connection $connection;

    /**
     * @var EntityRepository<CustomerGroupCollection>
     */
    private EntityRepository $customerGroupRepository;

    /**
     * @var EntityRepository<CustomerCollection>
     */
    private EntityRepository $customerRepository;

    public function injectServices(): void
    {
        $this->connection = $this->container->get(Connection::class);
        $this->translationHelper = new TranslationHelper($this->connection);
        $this->customerGroupRepository = $this->container->get('customer_group.repository');
        $this->customerRepository = $this->container->get('customer.repository');
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->customerGroupRepository->upsert($this->getCustomerGroupPayload(), $context);
        $this->customerRepository->upsert($this->getCustomerPayload(), $context);
    }

    public function update(): void
    {
    }

    public function uninstall(bool $keepUserData = false): void
    {
        if ($keepUserData) {
            return;
        }
        $context = $this->installContext->getContext();

        $ids = array_map(function ($group) {
            return ['id' => $group['id']];
        }, $this->getCustomerPayload());

        $this->customerRepository->delete($ids, $context);

        $ids = array_map(function ($group) {
            return ['id' => $group['id']];
        }, $this->getCustomerGroupPayload());

        $this->customerGroupRepository->delete($ids, $context);
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
    public function getCustomerGroupPayload(): array
    {
        return [
            [
                'id' => '0194265fbcac71f7bd3f7ff0e50ddc92',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '测试客户组',
                    'en-GB' => 'Testing customers group',
                ]),
            ],
            [
                'id' => '0199b38bc0d071f8ade734ab04e6374b',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => 'VIP 客户组',
                    'en-GB' => 'VIP Customer Group',
                ]),
            ],
            [
                'id' => '0199b38bd7f173f1870b7747a388ff3d',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '高价值客户组',
                    'en-GB' => 'High Value Customers Group',
                ]),
            ],
            [
                'id' => '0199b38be8917235a549bf67118e3cf6',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '新客户组',
                    'en-GB' => 'New Customers Group',
                ]),
            ],
            [
                'id' => '0199b38bfb7b7099acae50c6c41411d0',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '老客户组',
                    'en-GB' => 'Loyal Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c0cd8725a9d2faed30d56447b',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '区域客户组',
                    'en-GB' => 'Regional Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c211d7201a190235b94c1fd9c',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '潜在客户组',
                    'en-GB' => 'Potential Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c339e73e4841577cc6f4d9f77',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '线上客户组',
                    'en-GB' => 'Online Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c4a637219b4564a3ec1ff26ad',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '线下客户组',
                    'en-GB' => 'Offline Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c5ab273999b1c2a9b4d40de15',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '活跃客户组',
                    'en-GB' => 'Active Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c72e070ada7f9e3bc44295926',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '沉默客户组',
                    'en-GB' => 'Inactive Customers Group',
                ]),
            ],
            [
                'id' => '0199b38c8f8e7214a4f9459eb15e5a4c',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '大客户组',
                    'en-GB' => 'Key Customers Group',
                ]),
            ],
            [
                'id' => '0199b38ca5ef715ca21056dff3244e44',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '试用客户组',
                    'en-GB' => 'Trial Customers Group',
                ]),
            ],
            [
                'id' => '0199b38cb55871b19d11175f2920e3ca',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '企业客户组',
                    'en-GB' => 'Corporate Customers Group',
                ]),
            ],
            [
                'id' => '0199b38cc5ed723180133003e5ec6662',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '个人客户组',
                    'en-GB' => 'Individual Customers Group',
                ]),
            ],
            [
                'id' => '0199b38cd638720a8322f5aa792630e4',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '忠诚客户组',
                    'en-GB' => 'Loyalty Customers Group',
                ]),
            ],
            [
                'id' => '0199b38cee277215a1662f510c436483',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '高频客户组',
                    'en-GB' => 'Frequent Customers Group',
                ]),
            ],
            [
                'id' => '0199b38cfe9a70c592452829e92ea26e',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '低频客户组',
                    'en-GB' => 'Occasional Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d11eb72bcb949d929de1b94bc',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '批量客户组',
                    'en-GB' => 'Bulk Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d22bd73859ebbe50a5bfdc933',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '高潜力客户组',
                    'en-GB' => 'High Potential Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d37a37026b2d0b48b48be7f58',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '地域客户组',
                    'en-GB' => 'Regional Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d46e3712987003e200b40c501',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '高价值潜客组',
                    'en-GB' => 'High Value Leads Group',
                ]),
            ],
            [
                'id' => '0199b38d568c73e5b6b1b3980dc2a70c',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '新品客户组',
                    'en-GB' => 'New Product Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d710f728b80f079f726051b76',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '特殊客户组',
                    'en-GB' => 'Special Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d814172a399f13a658b16cf6f',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '促销客户组',
                    'en-GB' => 'Promotional Customers Group',
                ]),
            ],
            [
                'id' => '0199b38d926273d691ddd37b3e2be58f',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '内部客户组',
                    'en-GB' => 'Internal Customers Group',
                ]),
            ],
            [
                'id' => '0199b38da3607243a8fa9ae9f0ac8ba0',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '外部客户组',
                    'en-GB' => 'External Customers Group',
                ]),
            ],
            [
                'id' => '0199b38db70f707ca2796a4ea00e0ac5',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '测试用户组',
                    'en-GB' => 'Beta Customers Group',
                ]),
            ],
            [
                'id' => '0199b38dcbd07101a5a1e58b70e7125d',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '合作客户组',
                    'en-GB' => 'Partner Customers Group',
                ]),
            ],
            [
                'id' => '0199b38ddb977170942ad80deafab9b4',
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '忠实客户组',
                    'en-GB' => 'Faithful Customers Group',
                ]),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getCustomerPayload(): array
    {
        $channelId = $this->getFrontendChannel();

        return [
            [
                'id' => '6c97534c2c0747f39e8751e43cb2b013',
                'channelId' => $channelId,
                'customerNumber' => '1000200000022',
                'nickname' => '清风徐来',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'test@test.com',
                'active' => true,
                'phoneNumber' => '18000000000',
                'lastLogin' => '2019-06-12 07:13:39.641',
                'birthday' => '20001-06-06',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a3d12773a48920e114e216a41e',
                'channelId' => $channelId,
                'customerNumber' => '1000200000023',
                'nickname' => '星空漫游',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'zhangwei@email.com',
                'active' => true,
                'phoneNumber' => '13812345678',
                'lastLogin' => '2024-03-15 09:23:45.123',
                'birthday' => '1995-08-12',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a3ea9770bb903d7cd585caa928',
                'channelId' => $channelId,
                'customerNumber' => '1000200000024',
                'nickname' => '咖啡时光',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'liumei@email.com',
                'active' => true,
                'phoneNumber' => '13987654321',
                'lastLogin' => '2024-03-14 16:45:32.456',
                'birthday' => '1992-03-25',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a3fc4370ddb7da54f6ea04b645',
                'channelId' => $channelId,
                'customerNumber' => '1000200000025',
                'nickname' => '书香致远',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'wangtao@email.com',
                'active' => true,
                'phoneNumber' => '13711112222',
                'lastLogin' => '2024-03-13 11:15:28.789',
                'birthday' => '1988-11-08',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4136170749742f3ab4f89f0a8',
                'channelId' => $channelId,
                'customerNumber' => '1000200000026',
                'nickname' => '追风少年',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'chenlei@email.com',
                'active' => true,
                'phoneNumber' => '13622223333',
                'lastLogin' => '2024-03-12 14:32:19.654',
                'birthday' => '1998-05-18',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4255c70859b311318e9836d35',
                'channelId' => $channelId,
                'customerNumber' => '1000200000027',
                'nickname' => '月光倾城',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'zhaomin@email.com',
                'active' => true,
                'phoneNumber' => '13533334444',
                'lastLogin' => '2024-03-11 20:18:27.321',
                'birthday' => '1990-12-30',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a439ca723ca39c1e74436caa22',
                'channelId' => $channelId,
                'customerNumber' => '1000200000028',
                'nickname' => '阳光正好',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'sunyang@email.com',
                'active' => true,
                'phoneNumber' => '13444445555',
                'lastLogin' => '2024-03-10 08:45:12.987',
                'birthday' => '1993-07-22',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a44df772ee8dc9f0f4d2e17963',
                'channelId' => $channelId,
                'customerNumber' => '1000200000029',
                'nickname' => '雨中漫步',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'lixia@email.com',
                'active' => true,
                'phoneNumber' => '13355556666',
                'lastLogin' => '2024-03-09 13:27:45.654',
                'birthday' => '1985-09-14',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a46403714e85bb8b47244408d8',
                'channelId' => $channelId,
                'customerNumber' => '1000200000030',
                'nickname' => '云淡风轻',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'zhoujun@email.com',
                'active' => true,
                'phoneNumber' => '13266667777',
                'lastLogin' => '2024-03-08 17:39:21.123',
                'birthday' => '1996-04-03',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a476237311849244dd056a431f',
                'channelId' => $channelId,
                'customerNumber' => '1000200000031',
                'nickname' => '海阔天空',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'qiankun@email.com',
                'active' => true,
                'phoneNumber' => '13177778888',
                'lastLogin' => '2024-03-07 10:12:36.789',
                'birthday' => '1987-10-28',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a48ceb73e1b5fab3b11c493451',
                'channelId' => $channelId,
                'customerNumber' => '1000200000032',
                'nickname' => '春暖花开',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'huamei@email.com',
                'active' => true,
                'phoneNumber' => '13088889999',
                'lastLogin' => '2024-03-06 15:48:54.456',
                'birthday' => '1994-02-17',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a49f5d70898d71819f5db29052',
                'channelId' => $channelId,
                'customerNumber' => '1000200000033',
                'nickname' => '秋叶静美',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'yeqiu@email.com',
                'active' => true,
                'phoneNumber' => '13999990000',
                'lastLogin' => '2024-03-05 19:25:43.321',
                'birthday' => '1991-11-11',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4ae887008ae6b6f99be12a9c6',
                'channelId' => $channelId,
                'customerNumber' => '1000200000034',
                'nickname' => '冬日暖阳',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'handong@email.com',
                'active' => true,
                'phoneNumber' => '13800001111',
                'lastLogin' => '2024-03-04 12:37:29.654',
                'birthday' => '1989-01-25',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4c57f7231af4a99e2624c337e',
                'channelId' => $channelId,
                'customerNumber' => '1000200000035',
                'nickname' => '山河故人',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'shanhe@email.com',
                'active' => true,
                'phoneNumber' => '13711112222',
                'lastLogin' => '2024-03-03 16:54:18.987',
                'birthday' => '1997-06-09',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4e56273fe9fbeacd005499452',
                'channelId' => $channelId,
                'customerNumber' => '1000200000036',
                'nickname' => '时光旅人',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'shiguang@email.com',
                'active' => true,
                'phoneNumber' => '13622223333',
                'lastLogin' => '2024-03-02 21:08:47.123',
                'birthday' => '1993-08-19',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a4f6dc70e196847fd734265e9c',
                'channelId' => $channelId,
                'customerNumber' => '1000200000037',
                'nickname' => '梦里花落',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'mengli@email.com',
                'active' => true,
                'phoneNumber' => '13533334444',
                'lastLogin' => '2024-03-01 07:42:35.456',
                'birthday' => '1990-04-07',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a507ca725a87dbef99d7c0ae5c',
                'channelId' => $channelId,
                'customerNumber' => '1000200000038',
                'nickname' => '诗和远方',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'shiyuan@email.com',
                'active' => true,
                'phoneNumber' => '13444445555',
                'lastLogin' => '2024-02-28 14:19:26.789',
                'birthday' => '1986-12-15',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a51e5d7103a12c4df5ed98188c',
                'channelId' => $channelId,
                'customerNumber' => '1000200000039',
                'nickname' => '微笑向暖',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'weixiao@email.com',
                'active' => true,
                'phoneNumber' => '13355556666',
                'lastLogin' => '2024-02-27 18:31:42.321',
                'birthday' => '1995-03-28',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a537387364af50dc713f7622b9',
                'channelId' => $channelId,
                'customerNumber' => '1000200000040',
                'nickname' => '简单生活',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'jiandan@email.com',
                'active' => true,
                'phoneNumber' => '13266667777',
                'lastLogin' => '2024-02-26 09:57:13.654',
                'birthday' => '1992-09-05',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a54888730d9eacd902362af182',
                'channelId' => $channelId,
                'customerNumber' => '1000200000041',
                'nickname' => '宁静致远',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'ningjing@email.com',
                'active' => true,
                'phoneNumber' => '13177778888',
                'lastLogin' => '2024-02-25 22:14:58.987',
                'birthday' => '1988-07-31',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a5e2ef73c9bac531686e697ba3',
                'channelId' => $channelId,
                'customerNumber' => '1000200000026',
                'nickname' => '小太阳',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'xiaotaiyang@example.com',
                'active' => true,
                'phoneNumber' => '18000000001',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 08:12:23.123',
                'birthday' => '1995-01-01',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a5fddc7198a0964b18800b58cb',
                'channelId' => $channelId,
                'customerNumber' => '1000200000027',
                'nickname' => '夜雨声烦',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'yeyushengfan@example.com',
                'active' => true,
                'phoneNumber' => '18000000002',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 09:45:12.456',
                'birthday' => '1996-02-14',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a60e5d73458bf6aeea1f07417d',
                'channelId' => $channelId,
                'customerNumber' => '1000200000028',
                'nickname' => '萌萌哒',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'mengmengda@example.com',
                'active' => true,
                'phoneNumber' => '18000000003',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 11:20:33.789',
                'birthday' => '2000-05-05',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a6262e728aa60100082abbba8f',
                'channelId' => $channelId,
                'customerNumber' => '1000200000029',
                'nickname' => '风中追风',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'fengzhongzhuifeng@example.com',
                'active' => true,
                'phoneNumber' => '18000000004',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 12:10:10.321',
                'birthday' => '1998-08-08',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a63c3172b1b7f68ae92fbf7544',
                'channelId' => $channelId,
                'customerNumber' => '1000200000030',
                'nickname' => '兔兔酱',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'tutujiang@example.com',
                'active' => true,
                'phoneNumber' => '18000000005',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 13:15:44.654',
                'birthday' => '2001-03-22',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a65195718cae874a8f77fb98f1',
                'channelId' => $channelId,
                'customerNumber' => '1000200000031',
                'nickname' => '小可爱',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'xiaokeaiai@example.com',
                'active' => true,
                'phoneNumber' => '18000000006',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 14:22:11.987',
                'birthday' => '1999-11-11',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a66712704a99f2dc528c79d3f0',
                'channelId' => $channelId,
                'customerNumber' => '1000200000032',
                'nickname' => '快乐星球',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'kuailexingqiu@example.com',
                'active' => true,
                'phoneNumber' => '18000000007',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 15:05:05.123',
                'birthday' => '2002-07-07',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a6924e736f93681e39b68e22f9',
                'channelId' => $channelId,
                'customerNumber' => '1000200000033',
                'nickname' => '云端漫步',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'yunduimanbu@example.com',
                'active' => true,
                'phoneNumber' => '18000000008',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 16:10:22.456',
                'birthday' => '1997-12-12',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a67f2870e5bed23aa788dbc230',
                'channelId' => $channelId,
                'customerNumber' => '1000200000034',
                'nickname' => '小迷糊',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'xiaomihu@example.com',
                'active' => true,
                'phoneNumber' => '18000000009',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 17:25:33.789',
                'birthday' => '2000-06-06',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a6a80f73f48764452984296c67',
                'channelId' => $channelId,
                'customerNumber' => '1000200000035',
                'nickname' => '萌新小熊',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'mengxinxiaoxiong@example.com',
                'active' => true,
                'phoneNumber' => '18000000010',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 18:40:44.123',
                'birthday' => '2003-04-04',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a6b9d67217979f383168295497',
                'channelId' => $channelId,
                'customerNumber' => '1000200000036',
                'nickname' => '糖果小仙',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'tangguoxiaoxian@example.com',
                'active' => true,
                'phoneNumber' => '18000000011',
                'guest' => false,
                'newsletter' => true,
                'lastLogin' => '2025-09-28 19:55:55.456',
                'birthday' => '1998-09-09',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
            ],
            [
                'id' => '0199b3a6ced273dd901d84889c704922',
                'channelId' => $channelId,
                'customerNumber' => '1000200000037',
                'nickname' => '小懒猫',
                'password' => TestDefaults::HASHED_PASSWORD,
                'email' => 'xiaolanmao@example.com',
                'active' => true,
                'phoneNumber' => '18000000012',
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2025-09-28 20:10:10.789',
                'birthday' => '2001-05-05',
                'groupId' => '0199b38bc0d071f8ade734ab04e6374b',
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
}
