<?php
namespace NgsHarco\ParticipantAnniversary\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration202404030001AddAnniversaryLog extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 202404030001;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(
            'CREATE TABLE IF NOT EXISTS `ngs_harco_participant_anniversary_log` (
                `id` BINARY(16) NOT NULL,
                `participant_id` BINARY(16) NOT NULL,
                `anniversary_year` INT NOT NULL,
                `level_product_id` BINARY(16) NULL,
                `token` VARCHAR(128) NOT NULL UNIQUE,
                `token_expires_at` DATETIME(3) NOT NULL,
                `used_at` DATETIME(3) NULL,
                `sent_at` DATETIME(3) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.ngs_harco_participant_anniversary_log.participant_id`
                    FOREIGN KEY (`participant_id`) REFERENCES `ngs_harco_participant` (`id`) ON DELETE CASCADE,
                INDEX `idx.participant_year` (`participant_id`,`anniversary_year`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
