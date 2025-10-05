<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\TranslationHelper;
use HeyFrame\Core\Content\Category\CategoryCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;

class CategoryBootstrap extends AbstractBootstrap
{
    /**
     * @var EntityRepository<CategoryCollection>
     */
    private EntityRepository $categoryRepository;

    private TranslationHelper $translationHelper;

    public function injectServices(): void
    {
        $connection = $this->container->get(Connection::class);
        $this->categoryRepository = $this->container->get('category.repository');
        $this->translationHelper = new TranslationHelper($connection);
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->categoryRepository->upsert($this->getPayload(), $context);
    }

    public function getPayload(): array
    {
        return [
            [
                'id' => '01998723f6187075b5cb80b9f517037a',
                'active' => true,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '插件',
                    'en-GB' => 'Extensions',
                ]),
            ],
            [
                'id' => '019987272edc73359cae124382de3df0',
                'active' => true,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '主题',
                    'en-GB' => 'Themes',
                ]),
            ],
            [
                'id' => '019987277ecc7313adca2244ba00150d',
                'active' => true,
                'name' => $this->translationHelper->adjustTranslations([
                    'zh-CN' => '小程序',
                    'en-GB' => 'Mini program',
                ]),
            ],
        ];
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
        $ids = array_map(function ($group) {
            return ['id' => $group['id']];
        }, $this->getPayload());

        $this->categoryRepository->delete($ids, $context);
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
