<?php declare(strict_types=1);

namespace NotifyOnStock\Subscriber;

use NotifyOnStock\Service\MailService\MailService;
use Symfony\Component\HttpFoundation\RequestStack;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Content\Product\ProductEvents;

class OnProductLoadedSubscriber implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private MailService $emailService;

    public function __construct(RequestStack $requestStack, MailService $emailService)
    {
        $this->requestStack = $requestStack;
        $this->emailService = $emailService;
    }

    public static function getSubscribedEvents(): array
    {
        // Return the events to listen to as array like this:  <event to listen to> => <method to execute>
        return [
            ProductEvents::PRODUCT_LOADED_EVENT => 'onProductsLoaded'
        ];
    }

    public function onProductsLoaded(EntityLoadedEvent $event)
    {
        $this->requestStack->getSession()->set('context', $event->getContext());
    }
}