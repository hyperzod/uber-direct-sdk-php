<?php

namespace Hyperzod\UberDirectSdkPhp\Service;

/**
 * Service factory class for API resources in the root namespace.
 * @property QuoteService $quote
 * @property DeliveryService $delivery
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'delivery' => DeliveryService::class,
        'quote' => QuoteService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
