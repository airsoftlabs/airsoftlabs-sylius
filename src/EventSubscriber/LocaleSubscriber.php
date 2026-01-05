<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * ------------------------------------------------------------
 * LocaleSubscriber
 * ------------------------------------------------------------
 *
 * Purpose:
 * - Use English (en_US) as default locale WITHOUT URL prefix
 * - Use /nl prefix for Dutch (nl_NL)
 * - Prevent Symfony from appending ?_locale=en_US
 *
 * Resulting URLs:
 *   /              → en_US
 *   /product/slug  → en_US
 *   /nl/           → nl_NL
 *   /nl/product/slug → nl_NL
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    private string $defaultLocale;

    public function __construct(string $defaultLocale = 'en_US')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Locale coming from routing (/nl)
        $locale = $request->attributes->get('_locale');

        if (!$locale) {
            // No locale in URL → use default language
            $request->setLocale($this->defaultLocale);
            $request->attributes->set('_locale', $this->defaultLocale);
        } else {
            // Locale from prefix (e.g. /nl)
            $request->setLocale($locale);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => ['onKernelRequest', 20],
        ];
    }
}
