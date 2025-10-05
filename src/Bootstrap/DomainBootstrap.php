<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use Hey\PlatformDemoData\Helper\DbHelper;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\DevOps\Environment\EnvironmentHelper;
use HeyFrame\Core\Framework\Api\Context\SystemSource;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Channel\Aggregate\ChannelDomain\ChannelDomainCollection;

/**
 * @internal
 */
class DomainBootstrap extends AbstractBootstrap
{
    private Connection $connection;

    private DbHelper $dbHelper;

    /**
     * @var EntityRepository<ChannelDomainCollection>
     */
    private EntityRepository $channelDomainRepository;

    public function injectServices(): void
    {
        $this->connection = $this->container->get(Connection::class);
        $this->dbHelper = new DbHelper($this->connection);
        $this->channelDomainRepository = $this->container->get('channel_domain.repository');
    }

    public function install(): void
    {
        $channelId = $this->getFrontendChannel();
        $context = new Context(new SystemSource());
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('channelId', $channelId));
        /** @var ChannelDomainCollection $domains */
        $domains = $this->channelDomainRepository->search($criteria, $context)->getEntities();

        if (\count($domains) === 0) {
            return;
        }

        $englishId = $this->dbHelper->getLanguageId('en-GB');
        $chineseId = $this->dbHelper->getLanguageId('zh-CN');

        $enSnippetSetId = $this->getSnippetSetId('en-GB');
        $zhSnippetSetId = $this->getSnippetSetId('zh-CN');

        $appUrl = EnvironmentHelper::getVariable('APP_URL', 'http://localhost');

        $newDomainData = null;

        if ($enSnippetSetId !== null && $domains->filterByProperty('snippetSetId', $enSnippetSetId)->count() === 0) {
            $newDomainData = [
                'url' => $appUrl . '/en',
                'languageId' => $englishId,
                'snippetSetId' => $enSnippetSetId,
                'currencyId' => Defaults::CURRENCY,
            ];
        } elseif ($zhSnippetSetId !== null && $domains->filterByProperty('snippetSetId', $zhSnippetSetId)->count() === 0) {
            $newDomainData = [
                'url' => $appUrl . '/zh',
                'languageId' => $chineseId,
                'snippetSetId' => $zhSnippetSetId,
                'currencyId' => Defaults::CURRENCY,
            ];
        }

        if ($newDomainData !== null) {
            $domainUpsertData = \array_merge([
                'id' => '0195f2a18537713090842c238164d23e',
                'channelId' => $channelId,
            ], $newDomainData);

            $this->channelDomainRepository->upsert([$domainUpsertData], $context);
        }
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
        $this->channelDomainRepository->delete([
            [
                'id' => '0195f2a18537713090842c238164d23e',
            ],
        ], $context);
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
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

    private function getSnippetSetId(?string $isoCode = null): ?string
    {
        $result = $this->connection->fetchOne(
            '
                SELECT LOWER(HEX(id))
                FROM snippet_set
                WHERE iso = :languageCode
            ',
            ['languageCode' => $isoCode]
        );

        if ($result === false) {
            return null;
        }

        return (string) $result;
    }
}
