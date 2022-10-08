<?php declare(strict_types=1);

namespace NotifyOnStock\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductAlertDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'product_alert';

    public const FIELD_REGISTRATION_ID = 'id';
    public const FIELD_ID = 'productId';
    public const FIELD_EMAIL = 'email';
    public const FIELD_LANGUAGE = 'languageId';
    public const FIELD_QUANTITY = 'quantity';
    public const FIELD_STATUS = 'status';
    public const FIELD_SALES_CHANNEL_ID = 'salesChannelId';

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
            (new IdField('id', 'id'))->addFlags(new Required(),  new PrimaryKey()),
            (new IdField('product_id', 'productId'))->addFlags(new Required()),
            (new StringField('email', 'email'))->addFlags(new Required()),
            (new IdField('language_id', 'languageId'))->addFlags(new Required()),
            (new IntField('quantity', 'quantity'))->addFlags(new Required()),
            (new StringField('status', 'status')),
            (new IdField('sales_channel_id', 'salesChannelId'))->addFlags(new Required()),
        ]);
    }
}