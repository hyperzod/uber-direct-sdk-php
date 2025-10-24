<?php

namespace Hyperzod\UberDirectSdkPhp\Service;

use Hyperzod\UberDirectSdkPhp\Enums\HttpMethodEnum;

class QuoteService extends AbstractService
{
    /**
     * Create a delivery quote on UberDirect
     *
     * @param array $params
     *
     * @throws \Hyperzod\UberDirectSdkPhp\Exception\ApiErrorException if the request fails
     *
     */
    public function create(array $params)
    {
        return $this->request(HttpMethodEnum::POST, '/delivery_quotes', $params);
    }
}

