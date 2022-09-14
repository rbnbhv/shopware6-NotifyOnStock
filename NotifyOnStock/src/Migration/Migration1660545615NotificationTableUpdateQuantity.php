<?php declare(strict_types=1);

namespace NotifyOnStock\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1660545615NotificationTableUpdateQuantity extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1661159968;
    }

    /**
     * @throws Exception
     */
    public function update(Connection $connection): void
    {
        $connection->executeStatement ('
            ALTER TABLE notification_on_stock 
            MODIFY COLUMN quantity UNSIGNED TINYINT(100)  
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
