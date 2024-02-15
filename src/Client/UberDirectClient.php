<?php

namespace Hyperzod\UberDirectSdkPhp\Client;

use Hyperzod\UberDirectSdkPhp\Service\CoreServiceFactory;

class UberDirectClient extends BaseUberDirectClient
{
    /**
     * @var CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
