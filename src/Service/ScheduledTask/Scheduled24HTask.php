<?php declare(strict_types=1);

namespace NotifyOnStock\Service\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class Scheduled24HTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'reply_notify_on_stock.scheduled24HTask';
    }

    public static function getDefaultInterval(): int
    {
        //return 86400; // 24H
        return 10;
    }
}