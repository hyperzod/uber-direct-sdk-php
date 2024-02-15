<?php

namespace Hyperzod\UberDirectSdkPhp\Client;

/**
 * Interface for a UberDirect client.
 */
interface BaseUberDirectClientInterface
{
   /**
    * Gets the Merchant ID used by the client to send requests.
    *
    * @return null|string the Merchant ID used by the client to send requests
    */
   public function getCustomerID();

   /**
    * Gets the Client ID used by the client to send requests.
    *
    * @return null|string the Client ID used by the client to send requests
    */
   public function getClientID();

   /**
    * Gets the Client Secret used by the client to send requests.
    *
    * @return null|string the Client Secret used by the client to send requests
    */
   public function getClientSecret();

   /**
    * Gets the AUTH URL for UberDirect's API.
    *
    * @return string the AUTH URL for UberDirect's API
    */
   public function getAuthUrl();

   /**
    * Gets the base URL for UberDirect's API.
    *
    * @return string the base URL for UberDirect's API
    */
   public function getApiBase();

   /**
    * Get Access Token
    *
    * @return string the access token
    */
   public function getAccessToken();
}
