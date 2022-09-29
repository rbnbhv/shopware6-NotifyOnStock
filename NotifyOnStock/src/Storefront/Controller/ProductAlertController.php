<?php declare(strict_types=1);

namespace NotifyOnStock\Storefront\Controller;

use NotifyOnStock\Service\MailService\MailService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NotifyOnStock\Service\ReadData;
use NotifyOnStock\Service\WriteData;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class ProductAlertController extends StorefrontController
{
    private EntityRepository $productRepository;
    private ReadData $readingData;
    private WriteData $writeData;
    private MailService $emailService;

    public function __construct(EntityRepository $productRepository, ReadData $readingData, WriteData $writeData, MailService $emailService)
    {
        $this->productRepository = $productRepository;
        $this->readingData = $readingData;
        $this->writeData = $writeData;
        $this->emailService = $emailService;
    }

    /**
     * @Route("/{productName}/{productNumber}/notification-registered", name="frontend.productalert", methods={"post"})
     */
    public function submit(Request $request): Response
    {
        $session = $request->getSession();
        $request->request->set('b', '1');
//      For testing without scheduled Task:
//        $this->emailService->process();

        $textOutput = 'You have already been registered!';
        if ($this->writeData->fillTableWithNewEntity($request, $session->get('context'))) {
            $textOutput = 'You have been successfully registered to our notification alert. You will receive an Email soon!';
        }

        return $this->renderStorefront('@NotifyOnStock/storefront/page/example.html.twig', [
            'text' => $textOutput
        ]);
    }
}