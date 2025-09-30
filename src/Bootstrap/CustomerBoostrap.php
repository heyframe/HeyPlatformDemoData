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
                'guest' => false,
                'newsletter' => false,
                'lastLogin' => '2019-06-12 07:13:39.641',
                'birthday' => '20001-06-06',
                'groupId' => '0194265fbcac71f7bd3f7ff0e50ddc92',
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
