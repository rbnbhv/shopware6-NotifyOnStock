<?php declare(strict_types=1);

namespace NotifyOnStock\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1660545615NotificationTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1661159043;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement ('
            CREATE TABLE `notification_on_stock` (
                `id` BINARY(16) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `quantity` VARCHAR(255) NOT NULL,
                `language` VARCHAR(255) NOT NULL,
                `status` VARCHAR(255) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
