<?php declare(strict_types=1);

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class WriteData
{
    private EntityRepository $repository;

    public function __construct(){
    }

    public function subscribe(DataBag $data, Context $context): void
    {
        $this->validator->validate($data, $context);

        $entryData = [
            'email' => $data->get('email'),
            'productId' => $data->get('productId'),
        ];

        $this->repository->upsert([$entryData], $context);
    }
}