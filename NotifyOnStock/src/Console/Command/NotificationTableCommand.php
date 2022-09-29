<?php declare(strict_types=1);

namespace NotifyOnStock\Console\Command;


use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class NotificationTableCommand extends Command
{
    private EntityRepository $notificationOnStockTable;

    public function __construct(
        EntityRepository $notificationOnStockTable,
        string $name = null)
    {
        parent::__construct($name);
        $this->notificationOnStockTable = $notificationOnStockTable;
    }

    protected function configure()
    {
        $this->setName('notification_on_stock:list')->setDescription('List all registered Notifications');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $searchResult = $this->notificationOnStockTable->search(new Criteria(), Context::createDefaultContext());

        $table = new Table($output);
        $table->setHeaders(['UUID', 'Name']);
        foreach ($searchResult->getEntities() as $notificationOnStockTable) {
            $table->addRow([
                $notificationOnStockTable->getId(),
                $notificationOnStockTable->getName(),
            ]);
        }
        $table->render();
    }
}