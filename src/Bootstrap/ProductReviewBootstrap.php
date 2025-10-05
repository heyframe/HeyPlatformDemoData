<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

/**
 * @internal
 */
class ProductReviewBootstrap extends AbstractBootstrap
{
    public function install(): void
    {
        $this->container->get('product_review.repository')->upsert([
        ], $this->installContext->getContext());
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getPayload(): array
    {
        return [
            [
                'id' => '0199b54d3022705fa9847b796238a66e',
                'productId' => '1',
            ],
        ];
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
}
