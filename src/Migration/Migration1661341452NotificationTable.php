<?php declare(strict_types=1);

namespace NotifyOnStock\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1661341452NotificationTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1661341452;
    }

    /**
     * @throws Exception
     */
    public function update(Connection $connection): void
    {
        $connection->executeStatement ('
            CREATE TABLE `product_alert` (
                id               binary(16)                          not null   primary key,
                product_id       binary(16)                          not null,
                email            varchar(255)                        not null,
                language_id      binary(16)                          not null,
                quantity         int(255) unsigned default 1         not null,
                status           varchar(255)      default "pending" not null,
                created_at       datetime(3)                         not null,
                updated_at       datetime(3)                         null,
                sales_channel_id binary(16)                          not null,
                constraint notification_on_stock_registration_id_uindex unique (id),
                constraint product_alert_foreign_key foreign key (product_id) references product (id) on delete cascade,
                constraint product_alert_language_id_fk foreign key (language_id) references language (id),
                constraint product_alert_sales_channel_null_fk foreign key (sales_channel_id) references sales_channel (id)
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
