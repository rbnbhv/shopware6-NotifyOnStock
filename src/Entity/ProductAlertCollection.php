<?php declare(strict_types=1);

namespace NotifyOnStock\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class ProductAlertCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return ProductAlertEntity::class;
    }
}