<?php

namespace Hyperzod\UberDirectSdkPhp\Service;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
   /**
    * @var \Hyperzod\UberDirectSdkPhp\Client\UberDirectClientInterface
    */
   protected $client;

   /**
    * Initializes a new instance of the {@link AbstractService} class.
    *
    * @param \Hyperzod\UberDirectSdkPhp\Client\UberDirectClientInterface $client
    */
   public function __construct($client)
   {
      $this->client = $client;
   }

   /**
    * Gets the client used by this service to send requests.
    *
    * @return \Hyperzod\UberDirectSdkPhp\Client\UberDirectClientInterface
    */
   public function getClient()
   {
      return $this->client;
   }

   protected function request($method, $path, $params)
   {
      return $this->getClient()->request($method, $path, $params);
   }
}
