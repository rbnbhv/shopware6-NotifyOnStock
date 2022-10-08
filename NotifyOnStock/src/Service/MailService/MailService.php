<?php declare(strict_types=1);

namespace NotifyOnStock\Service\MailService;

use NotifyOnStock\Entity\ProductAlertEntity;
use NotifyOnStock\Service\ReadData;
use NotifyOnStock\Service\WriteData;
use Shopware\Core\Content\Mail\Service\AbstractMailService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\AndFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Validation\DataBag\DataBag;

class MailService
{
    private AbstractMailService $mailService;
    private ReadData $readingData;
    private WriteData $writeData;
    private EntityRepository $seoRepository;
    private EntityRepository $salesChannelDomainRepository;
    private EntityRepository $productRepository;
    private EntityRepositoryInterface $mailTemplateRepository;
    private EntityRepository $mailTemplateTranslationRepository;

    public function __construct
    (
        AbstractMailService $mailService,
        ReadData $readData, WriteData $writeData,
        EntityRepository $productRepository,
        EntityRepository $seoRepository,
        EntityRepository $salesChannelDomainRepository,
        EntityRepositoryInterface $mailTemplateRepository,
        EntityRepository $mailTemplateTranslationRepository
    ) {
        $this->mailService = $mailService;
        $this->readingData = $readData;
        $this->productRepository = $productRepository;
        $this->seoRepository = $seoRepository;
        $this->salesChannelDomainRepository = $salesChannelDomainRepository;
        $this->writeData = $writeData;
        $this->mailTemplateRepository = $mailTemplateRepository;
        $this->mailTemplateTranslationRepository = $mailTemplateTranslationRepository;
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

    public function sendMail(Context $context, ProductAlertEntity $row): void
    {
        // fetching mail template with name product_alert from mailTemplateTypeRepository using mailTemplateRepository
        $criteria = $this->setAndFilterCriteria('mailTemplateType.technicalName', 'product_alert', 'mailTemplateType.technicalName', 'product_alert');
        $mailTemplate = $this->mailTemplateRepository->search($criteria, $context)->first();

        // fetching sales channel Id
        $criteria1 = $this->setAndFilterCriteria("salesChannelId", $row->get("salesChannelId"), 'languageId', $row->get('languageId'));
        $baseUrl = $this->salesChannelDomainRepository->search($criteria1, $context)->first()->get('url');

        // using product Id to fetch the link from seoRepository
        $criteria2 = $this->setAndFilterCriteria('foreignKey', $row->get('productId'), 'languageId', $row->get('languageId'));
        $productPath = $this->seoRepository->search($criteria2, $context)->first()->get("seoPathInfo");
        $fullUrl = $baseUrl."/".$productPath;

        // fetching the right translation of the template
        $criteria3 = $this->setAndFilterCriteria('mailTemplateId', $mailTemplate->get('id'), 'languageId', $row->get('languageId'));
        $mailTemplateTranslation = $this->mailTemplateTranslationRepository->search($criteria3, Context::createDefaultContext())->first();

        $data = new DataBag();
        $data->set(
            'recipients',
            [
                $row->get('email') => 'Registered Client'
            ]
        );

        $data->set('senderName', $mailTemplate->getSenderName());
        $data->set('salesChannelId', $row->get('salesChannelId'));
        $data->set('contentHtml', $mailTemplateTranslation->get('contentHtml'));
        $data->set('contentPlain', $mailTemplateTranslation->get('contentPlain'));
        $data->set('subject', $mailTemplateTranslation->get('subject'));
        $data->set('templateId', $mailTemplate->getId());
        $data->set('mediaIds', []);

        if($this->mailService->send($data->all(), $context, ['shopName' => 'Ihr Online-Shop', 'fullPath' => $fullUrl, 'productName' => 'Name'])) {
            // update status to sent
            $this->writeData->updateStatus($context, $row);
        }
    }

    public function process(): void
    {
        // fetch all rows with status = pending
        $rowsToHandle = $this->readingData->getRows('status', 'pending');
        foreach ($rowsToHandle as $row) {
            // check if the product is available again
            if ($this->productRepository->search(new Criteria([$row->get('productId')]), Context::createDefaultContext())->first()->get('availableStock') >= $row->get('quantity') ) {
                $this->sendMail(Context::createDefaultContext(), $row);
            }
        }
    }
}