<?php declare(strict_types=1);

namespace ReplyNotifyOnStock\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ReplyNotifyOnStock\Service\ReadingData;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class ProductAlertController extends StorefrontController
{
    private ReadingData $readingData;
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository, ReadingData $readingData)
    {
        $this->readingData = $readingData;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/{productName}/{productNumber}/notification-registered", name="frontend.productalert", methods={"Post"})
     */
    public function showExample(Context $context, EntityRepository $productRepository): Response
    {
        dd($this->readingData->readData($context, $productRepository));

        $this->renderStorefront('@ReplyNotifyOnStock/storefront/page/example.html.twig', [
            'page' => $repositoryInfo
        ]);
    }
}