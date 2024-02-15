<?php

namespace Hyperzod\UberDirectSdkPhp\Service;

/**
 * Service factory class for API resources in the root namespace.
 * @property QuoteService $QuoteService
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'quote' => QuoteService::class,
        'order' => OrderService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
