<?php declare(strict_types=1);

namespace NotifyOnStock\Service;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class ReadData
{
    private EntityRepository $product_alert;

    public function __construct(EntityRepository $product_alert)
    {
        $this->product_alert = $product_alert;
    }

    public function searchById(Context $context, string $id): ProductEntity
    {
        return $this->product_alert->search(new Criteria([$id]), $context)->first();
    }

    public function getRows(string $field, string $value): array
    {
        $criteria = new Criteria();
        $criteria->addPostFilter(new EqualsFilter($field, $value));
        return $this->product_alert->search($criteria, Context::createDefaultContext())->getElements();
    }
}