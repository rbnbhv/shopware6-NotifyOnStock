<?php declare(strict_types=1);

namespace NotifyOnStock\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductAlertEntityDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'product_alert';

    public function getCollectionClass(): string
    {
        return ProductAlertCollection::class;
    }

    public function getEntityClass(): string
    {
        return ProductAlertEntity::class;
    }

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('uuid', 'uuid'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('email', 'email'))->addFlags(new Required()),
            (new StringField('language', 'language'))->addFlags(new Required()),
            (new IntegerField('quantity', 'quantity'))->addFlags(new Required()),
            (new StringField('status', 'status'))
        ]);
    }
}