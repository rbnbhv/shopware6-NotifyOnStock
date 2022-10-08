<?php declare(strict_types=1);

namespace NotifyOnStock\Service;

use Egulias\EmailValidator\Parser\IDLeftPart;
use NotifyOnStock\Entity\ProductAlertEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\AndFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class WriteData
{
    private EntityRepository $productAlertEntityRepository;
    private EntityRepository $languageRepository;

    public function __construct(EntityRepository $productAlertEntityRepository, EntityRepository $languageRepository)
    {
        $this->productAlertRepository = $productAlertEntityRepository;
        $this->languageRepository = $languageRepository;
    }

    public function setAndFilterCriteria(string $field1, string $value1, string $field2, string $value2): Criteria
    {
        $criteria = new Criteria();
        $criteria->addFilter(new andFilter([
            new EqualsFilter($field1, $value1),
            new EqualsFilter($field2, $value2),
        ]));
        return $criteria;
    }

    public function updateStatus(Context $context, ProductAlertEntity $row): void
    {
        $this->productAlertRepository->update([
            [
                'id' => $row->get('id'),
                'status' => 'sent',
            ]
        ], $context);
    }

    public function fillTableWithNewEntity(Request $request, Context $context) : bool
    {
        $productId = $request->request->get('product_id');
        $email = $request->request->get('email');
        $quantity = (int)$request->request->get('quantity');
        $salesChannelId = $request->get('sw-sales-channel-id');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', $request->request->get('language')));
        $language = $this->languageRepository->search($criteria, Context::createDefaultContext())->first();

        $criteria = $this->setAndFilterCriteria('productId', $productId, 'email', $email);

        /** @var  ProductAlertEntity $productAlertEntity */
        $productAlertEntity = $this->productAlertRepository->search($criteria, $context)->first();

        if ($productAlertEntity === null) {
            $entryData = [
                'id' => Uuid::randomHex(),
                'productId' => $productId,
                'email' => $email,
                'quantity' => $quantity,
                'languageId' => $language->get('id'),
                'salesChannelId' => $salesChannelId,
            ];
            $this->productAlertRepository->upsert([$entryData], $context);
            return true;
        }

        else if ($productAlertEntity->get('quantity') !== (int)$request->request->get('quantity')) {
            $criteria->addFilter(new andFilter([new EqualsFilter('status', 'pending'), new EqualsFilter('quantity', $request->request->get('quantity'))]));
            $this->productAlertRepository->update([
                [
                    'id' => $productAlertEntity->get('id'),
                    'quantity' => (int)$request->request->get('quantity'),
                    'status' => 'pending',
                    'language' => $language->get('id'),
                ]
            ], $context);
            return true;
        }
        return false;
    }
}