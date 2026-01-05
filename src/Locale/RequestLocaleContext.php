<?php

namespace App\Locale;

use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * ------------------------------------------------------------
 * RequestLocaleContext
 * ------------------------------------------------------------
 *
 * Forces Sylius to use the locale resolved by Symfony routing
 * (/, /nl) and prevents Sylius from redirecting via
 * sylius_shop_default_locale.
 */
final class RequestLocaleContext implements LocaleContextInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private string $defaultLocale = 'en_US'
    ) {}

    public function getLocaleCode(): string
    {
        $request = $this->requestStack->getMainRequest();

        if ($request && $request->getLocale()) {
            return $request->getLocale();
        }

        return $this->defaultLocale;
    }
}
