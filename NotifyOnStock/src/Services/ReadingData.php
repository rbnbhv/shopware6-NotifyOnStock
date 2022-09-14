<?php declare(strict_types=1);

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Content\Product\ProductEntity;

class ReadingData
{
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * @param Context $context
     * @return void
     */
    public function readData(Context $context, EntityRepository $productRepository): ProductEntity
    {
        return $this->productRepository->search(new Criteria(['1901dc5e888f4b1ea4168c2c5f005540']), $context)->first();
    }
}