<?php declare(strict_types=1);

namespace Hey\PlatformDemoData\Bootstrap;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Content\Media\File\FileSaver;
use HeyFrame\Core\Content\Media\File\MediaFile;
use HeyFrame\Core\Content\Media\MediaCollection;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;

/**
 * @internal
 */
class MediaBoostrap extends AbstractBootstrap
{
    private FileSaver $fileSaver;

    private Connection $connection;

    /**
     * @var EntityRepository<MediaCollection>
     */
    private EntityRepository $mediaRepository;

    public function injectServices(): void
    {
        $this->fileSaver = $this->container->get(FileSaver::class);
        $this->connection = $this->container->get(Connection::class);
        $this->mediaRepository = $this->container->get('media.repository');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getPayload(): array
    {
        $cmsFolder = $this->getDefaultFolderIdForEntity('cms_page');
        $productFolder = $this->getDefaultFolderIdForEntity('product');

        return [
            [
                'id' => '11dc680240b04f469ccba354cbf0b967',
                'mediaFolderId' => $productFolder,
            ],
        ];
    }

    public function install(): void
    {
        $context = $this->installContext->getContext();
        $this->mediaRepository->upsert($this->getPayload(), $context);
        $this->finalize($context);
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
        $this->mediaRepository->delete($this->getPayload(), $context);
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
    }

    public function finalize(Context $context): void
    {
        $files = \glob(__DIR__ . '/../Resources/media/*/*.{jpg,png,svg}', \GLOB_BRACE);
        if ($files === false) {
            return;
        }

        foreach ($files as $file) {
            $mimeType = \mime_content_type($file);

            if ($mimeType === false) {
                $mimeType = 'application/octet-stream';
            }

            $filesize = \filesize($file);
            if ($filesize === false) {
                $filesize = 0;
            }
            $this->fileSaver->persistFileToMedia(
                new MediaFile(
                    $file,
                    $mimeType,
                    \pathinfo($file, \PATHINFO_EXTENSION),
                    $filesize
                ),
                \pathinfo($file, \PATHINFO_FILENAME),
                \basename(\dirname($file)),
                $context
            );
        }
    }

    private function getDefaultFolderIdForEntity(string $entity): string
    {
        $result = $this->connection->fetchOne('
            SELECT LOWER(HEX(`media_folder`.`id`))
            FROM `media_default_folder`
            JOIN `media_folder` ON `media_default_folder`.`id` = `media_folder`.`default_folder_id`
            WHERE `media_default_folder`.`entity` = :entity;
        ', ['entity' => $entity]);

        if ($result === false) {
            throw new \RuntimeException('No default folder for entity "' . $entity . '" found, please make sure that basic data is available by running the migrations.');
        }

        return (string) $result;
    }
}
