<?php declare(strict_types=1);

namespace NotifyOnStock\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1660545615NotificationMailTemplate extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1660545615;
    }

    public function update(Connection $connection): void
    {
        // implement update
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
