<?php

namespace Hyperzod\UberDirectSdkPhp\Client;

/**
 * Interface for a UberDirect client.
 */
interface UberDirectClientInterface extends BaseUberDirectClientInterface
{
   /**
    * Sends a request to UberDirect's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */
   public function request($method, $path, $params);
}
