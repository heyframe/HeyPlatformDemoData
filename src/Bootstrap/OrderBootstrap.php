<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Checkout\Cart\Channel\CartService;
use HeyFrame\Core\Checkout\Cart\LineItem\LineItem;
use HeyFrame\Core\Checkout\Cart\LineItem\LineItemCollection;
use HeyFrame\Core\Checkout\Order\Api\OrderActionController;
use HeyFrame\Core\Checkout\Order\OrderCollection;
use HeyFrame\Core\Checkout\Order\OrderEntity;
use HeyFrame\Core\Checkout\Payment\PaymentMethodCollection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\Channel\Context\ChannelContextFactory;
use HeyFrame\Core\System\Channel\Context\ChannelContextService;
use Symfony\Component\HttpFoundation\Request;

use function PHPUnit\Framework\assertNotNull;

/**
 * @internal
 */
class OrderBootstrap extends AbstractBootstrap
{
    /**
     * @var EntityRepository<OrderCollection>
     */
    private EntityRepository $orderRepository;

    private CartService $cartService;

    private OrderActionController $orderActionController;

    public function injectServices(): void
    {
        $this->orderRepository = $this->container->get('order.repository');
        $this->cartService = $this->container->get(CartService::class);
        $this->orderActionController = $this->container->get(OrderActionController::class);
    }

    public function install(): void
    {
        $this->createOrder('0199b3a6ced273dd901d84889c704922', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '11dc680240b04f469ccba354cbf0b967'),
        ]));
        $this->createOrder('0199b3a6b9d67217979f383168295497', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b379822971f79ad6187191f4c289'),
        ]));
        $this->createOrder('0199b3a6a80f73f48764452984296c67', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b379822971f79ad6187191f4c289'),
        ]));
        $this->createOrder('0199b3a67f2870e5bed23aa788dbc230', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b378412271dabcccfe59503d8873'),
        ]));
        $this->createOrder('0199b3a6924e736f93681e39b68e22f9', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b377313c7388be973db263d5c7d9'),
        ]));
        $this->createOrder('0199b3a66712704a99f2dc528c79d3f0', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b3729b3270e6814a802371089892'),
        ]));
        $this->createOrder('0199b3a65195718cae874a8f77fb98f1', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b36f8bbe72a0925f41d601ffd9b1'),
        ]));
        $this->createOrder('0199b3a63c3172b1b7f68ae92fbf7544', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b36e20c8719d842eae59ff95408b'),
        ]));
        $this->createOrder('0199b3a6262e728aa60100082abbba8f', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b36be2b77259a72ebf67845ca4c8'),
        ]));
        $this->createOrder('0199b3a60e5d73458bf6aeea1f07417d', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b3682dc672cba8ab8bd78327e613'),
        ]));
        $this->createOrder('0199b3a5fddc7198a0964b18800b58cb', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b365c4b3732396a201a49fb8eab5'),
        ]));
        $this->createOrder('0199b3a5e2ef73c9bac531686e697ba3', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b363f7eb73ea96f2090ec8861526'),
        ]));
        $this->createOrder('0199b3a54888730d9eacd902362af182', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199b35f066b727580a20e372242a142'),
        ]));
        $this->createOrder('0199b3a537387364af50dc713f7622b9', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199a54ccb1373ef8dadaa5e80d271b1'),
        ]), ['process', 'complete'], ['process', 'paid']);
        $this->createOrder('0199b3a51e5d7103a12c4df5ed98188c', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199555fc844736f820726d460521d60'),
        ]));
        $this->createOrder('0199b3a507ca725a87dbef99d7c0ae5c', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199555d62ee701b8fe211a6b96a062c'),
        ]));
        $this->createOrder('0199b3a4f6dc70e196847fd734265e9c', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '0199527b924070a2b8e6614df8e09675'),
        ]));
        $this->createOrder('0199b3a4e56273fe9fbeacd005499452', new LineItemCollection([
            new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, '11dc680240b04f469ccba354cbf0b967'),
        ]));
    }

    public function update(): void
    {
    }

    public function uninstall(bool $keepUserData = false): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('extraFields.is_demo_data', 'true'));

        $orderIds = $this->orderRepository->searchIds($criteria, $this->installContext->getContext())->getIds();

        if (!empty($orderIds)) {
            $deletePayload = array_map(fn (string $id) => ['id' => $id], $orderIds);
            $this->orderRepository->delete($deletePayload, $this->installContext->getContext());
        }
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
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
     * @param array<string> orderState
     * @param array<string> $payState
     */
    private function createOrder(string $customerId, LineItemCollection $items, array $orderState = [], array $payState = []): void
    {
        /** @var ChannelContextFactory $channelContextFactory */
        $channelContextFactory = $this->container->get(ChannelContextFactory::class);
        $token = Uuid::randomHex();
        $channelContext = $channelContextFactory->create(
            $token,
            $this->getFrontendChannel(),
            [
                ChannelContextService::CUSTOMER_ID => $customerId,
            ]
        );

        $cart = $this->cartService->createNew($token);
        $cart->addLineItems($items);

        $orderId = $this->cartService->order($cart, $channelContext, new RequestDataBag());

        $this->orderRepository->update([[
            'id' => $orderId,
            'extraFields' => [
                'is_demo_data' => true,
            ],
        ]], $this->installContext->getContext());

        if (\count($orderState) > 0) {
            foreach ($orderState as $value) {
                $this->orderActionController->orderStateTransition($orderId, $value, new Request(), $this->installContext->getContext());
            }
        }

        if (\count($payState) > 0) {
            $criteria = new Criteria([$orderId]);
            $criteria->addAssociation('primaryOrderTransaction');
            /** @var OrderEntity|null $order */
            $order = $this->orderRepository->search($criteria, $this->installContext->getContext())->first();
            assertNotNull($order);
            foreach ($payState as $value) {
                $orderTransaction = $order->getPrimaryOrderTransaction();
                if ($orderTransaction === null) {
                    return;
                }
                $this->orderActionController->orderTransactionStateTransition($orderTransaction->getId(), $value, new Request(), $this->installContext->getContext());
            }
        }
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
