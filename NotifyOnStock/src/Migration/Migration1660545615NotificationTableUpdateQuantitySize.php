<?php declare(strict_types=1);

namespace NotifyOnStock\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1660545615NotificationTableUpdateQuantitySize extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1661163504;
    }

    /**
     * @throws Exception
     */
    public function update(Connection $connection): void
    {
        $connection->executeStatement ('
            ALTER TABLE notification_on_stock 
            MODIFY COLUMN quantity TINYINT(100) UNSIGNED   
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
