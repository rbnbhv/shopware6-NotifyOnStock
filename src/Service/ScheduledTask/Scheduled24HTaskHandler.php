<?php declare(strict_types=1);

namespace NotifyOnStock\Service\ScheduledTask;


use NotifyOnStock\Service\MailService\MailService;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;

class Scheduled24HTaskHandler extends ScheduledTaskHandler
{
    private MailService $emailService;

    public function __construct(
        EntityRepositoryInterface $scheduledTaskRepository,
        MailService $emailService
    ) {
        parent::__construct($scheduledTaskRepository);
        $this->emailService = $emailService;
    }

    public static function getHandledMessages(): iterable
    {
        $test = [Scheduled24HTask::class];
//        var_dump($test);
        return $test;
    }

    public function run(): void
    {
        $this->emailService->process();
    }
}