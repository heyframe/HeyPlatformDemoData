<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Checkout\Cart\LineItem\LineItem;
use HeyFrame\Core\Checkout\Cart\Price\Struct\CartPrice;
use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Checkout\Order\OrderCollection;
use HeyFrame\Core\Checkout\Order\OrderStates;
use HeyFrame\Core\Checkout\Payment\PaymentMethodCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Pricing\CashRoundingConfig;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Channel\ChannelContext;
use HeyFrame\Core\System\Channel\Context\ChannelContextFactory;
use HeyFrame\Core\System\StateMachine\Loader\InitialStateIdLoader;

/**
 * @internal
 */
class OrderBootstrap extends AbstractBootstrap
{
    /**
     * @var EntityRepository<OrderCollection>
     */
    private EntityRepository $orderRepository;

    private ChannelContext $channelContext;

    public function injectServices(): void
    {
        $this->orderRepository = $this->container->get('order.repository');
        /** @var ChannelContextFactory $channelContextFactory */
        $channelContextFactory = $this->container->get(ChannelContextFactory::class);
        $this->channelContext = $channelContextFactory->create(
            Uuid::randomHex(),
            $this->getFrontendChannel()
        );
    }

    public function install(): void
    {
        // TODO: Implement install() method.
    }

    public function update(): void
    {
        // TODO: Implement update() method.
    }

    public function uninstall(bool $keepUserData = false): void
    {
        // TODO: Implement uninstall() method.
    }

    public function activate(): void
    {
        // TODO: Implement activate() method.
    }

    public function deactivate(): void
    {
        // TODO: Implement deactivate() method.
    }

    protected function getValidPaymentMethodId(?string $channelId = null): string
    {
        /** @var EntityRepository<PaymentMethodCollection> $repository */
        $repository = $this->container->get('payment_method.repository');

        $criteria = (new Criteria())
            ->setLimit(1)
            ->addFilter(new EqualsFilter('active', true));

        if ($channelId) {
            $criteria->addFilter(new EqualsFilter('channels.id', $channelId));
        }

        /** @var string $id */
        $id = $repository->searchIds($criteria, $this->installContext->getContext())->firstId();

        return $id;
    }

    /**
     * @param array<string|int, mixed> $items
     *
     * @return array<string,mixed>
     */
    private function getOrderData(string $orderId, string $customerId, array $items): array
    {
        /** @var CustomerEntity $customer */
        $customer = $this->container->get('customer.repository')->search(new Criteria([$customerId]), $this->installContext->getContext());
        $lineItems = [];
        foreach ($items as $item) {
            $type = $item['type'];
            if ($type === LineItem::PRODUCT_LINE_ITEM_TYPE) {
                $product = $this->container->get('channel.product.repository')->search(new Criteria([$item['referencedId']]), $this->channelContext);
                $lineItems[] = [
                    'id' => $item['referencedId'],
                    'referenceId' => $item['referencedId'],
                    'type' => $item['type'],
                ];
            }
        }

        return [
            'id' => $orderId,
            'itemRounding' => json_decode(json_encode(new CashRoundingConfig(2, 0.01, true), \JSON_THROW_ON_ERROR), true, 512, \JSON_THROW_ON_ERROR),
            'totalRounding' => json_decode(json_encode(new CashRoundingConfig(2, 0.01, true), \JSON_THROW_ON_ERROR), true, 512, \JSON_THROW_ON_ERROR),
            'orderDateTime' => (new \DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
            'price' => new CartPrice(0, 0, 0),
            'stateId' => $this->container->get(InitialStateIdLoader::class)->get(OrderStates::STATE_MACHINE),
            'paymentMethodId' => $this->getValidPaymentMethodId(),
            'currencyId' => Defaults::CURRENCY,
            'currencyFactor' => 1,
            'channelId' => $customer->getChannelId(),
            'lineItems' => $lineItems,
            'orderCustomer' => [
                'id' => $orderId,
                'email' => $customer->getEmail(),
                'nickname' => $customer->getNickname(),
                'name' => $customer->getName(),
                'customerNumber' => $customer->getCustomerNumber(),
                'customerId' => $customer->getId(),
            ],
        ];
    }

    private function getFrontendChannel(): string
    {
        $result = $this->container->get(Connection::class)->fetchOne('
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
