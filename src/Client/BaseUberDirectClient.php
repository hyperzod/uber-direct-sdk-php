<?php

namespace Hyperzod\UberDirectSdkPhp\Client;

use Exception;
use GuzzleHttp\Client;
use Hyperzod\UberDirectSdkPhp\Exception\InvalidArgumentException;

class BaseUberDirectClient implements UberDirectClientInterface
{

   /** @var array<string, mixed> */
   private $config;

   /**
    * Initializes a new instance of the {@link BaseUberDirectClient} class.
    *
    * The constructor takes two arguments.
    * @param string $client_id the Client ID of the client
    * @param string $api_base the base URL for UberDirect's API
    */

   public function __construct($client_id, $client_secret, $merchant_id, $api_base)
   {
      $config = $this->validateConfig(array(
         "client_id" => $client_id,
         "client_secret" => $client_secret,
         "merchant_id" => $merchant_id,
         "api_base" => $api_base
      ));

      $this->config = $config;
   }

   /**
    * Gets the Client ID used by the client to send requests.
    *
    * @return null|string the Client ID used by the client to send requests
    */
   public function getClientID()
   {
      return $this->config['client_id'];
   }

   /**
    * Gets the Client Secret used by the client to send requests.
    *
    * @return null|string the Client Secret used by the client to send requests
    */
   public function getClientSecret()
   {
      return $this->config['client_secret'];
   }

   /**
    * Gets the Merchant ID used by the client to send requests.
    *
    * @return null|string the Merchant ID used by the client to send requests
    */
   public function getMerchantID()
   {
      return $this->config['merchant_id'];
   }

   /**
    * Gets the base URL for UberDirect's API.
    *
    * @return string the base URL for UberDirect's API
    */
   public function getApiBase()
   {
      return $this->config['api_base'];
   }

   /**
    * Get Access Token
    *
    * @return string the access token
    */
   public function getAccessToken()
   {
      // Combine client_id and client_secret with a colon
      $credentials = $this->getClientID() . ':' . $this->getClientSecret();

      // Base64 encode the combined string
      $base64Credentials = base64_encode($credentials);

      // Instantiate a Guzzle client
      $client = new Client();

      // Define the request parameters
      $requestParams = [
         'headers' => [
            'Authorization' => 'Basic ' . $base64Credentials,
            'Content-Type' => 'application/x-www-form-urlencoded',
         ],
         'form_params' => [
            'grant_type' => 'client_credentials',
         ],
      ];

      $authTokenUrl = "https://auth.prod.uber-direct.io/oauth2/token";
      if (strpos($this->getApiBase(), 'sandbox') !== false) {
         $authTokenUrl = "https://auth.sandbox.uber-direct.io/oauth2/token";
      }
      // Make the POST request
      $response = $client->post($authTokenUrl, $requestParams);

      // Get the response body as a string
      $responseBody = $response->getBody()->getContents();

      // Decode the JSON response
      $result = json_decode($responseBody, true);

      return $result['access_token'];
   }


   /**
    * Sends a request to uber-direct's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */

   public function request($method, $path, $params)
   {
      $client = new Client([
         'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'X-uber-direct-MERCHANT-ID' => $this->getMerchantID()
         ]
      ]);

      $api = $this->getApiBase() . $path;

      $response = $client->request($method, $api, [
         'http_errors' => true,
         'body' => json_encode($params)
      ]);

      return $this->validateResponse($response);
   }

   /**
    * @param array<string, mixed> $config
    *
    * @throws InvalidArgumentException
    */
   private function validateConfig($config)
   {
      // client_id
      if (!isset($config['client_id'])) {
         throw new InvalidArgumentException('client_id field is required');
      }

      if (!is_string($config['client_id'])) {
         throw new InvalidArgumentException('client_id must be a string');
      }

      if ('' === $config['client_id']) {
         throw new InvalidArgumentException('client_id cannot be an empty string');
      }

      if (preg_match('/\s/', $config['client_id'])) {
         throw new InvalidArgumentException('client_id cannot contain whitespace');
      }

      if (!isset($config['client_secret'])) {
         throw new InvalidArgumentException('client_secret field is required');
      }

      if (!is_string($config['client_secret'])) {
         throw new InvalidArgumentException('client_secret must be a string');
      }

      if ('' === $config['client_secret']) {
         throw new InvalidArgumentException('client_secret cannot be an empty string');
      }

      if (preg_match('/\s/', $config['client_secret'])) {
         throw new InvalidArgumentException('client_secret cannot contain whitespace');
      }

      if (!isset($config['client_secret'])) {
         throw new InvalidArgumentException('client_secret field is required');
      }

      if (!is_string($config['merchant_id'])) {
         throw new InvalidArgumentException('merchant_id must be a string');
      }

      if ('' === $config['merchant_id']) {
         throw new InvalidArgumentException('merchant_id cannot be an empty string');
      }

      if (preg_match('/\s/', $config['merchant_id'])) {
         throw new InvalidArgumentException('merchant_id cannot contain whitespace');
      }

      if (!isset($config['api_base'])) {
         throw new InvalidArgumentException('api_base field is required');
      }

      if (!is_string($config['api_base'])) {
         throw new InvalidArgumentException('api_base must be a string');
      }

      if ('' === $config['api_base']) {
         throw new InvalidArgumentException('api_base cannot be an empty string');
      }

      return [
         "client_id" => $config['client_id'],
         "client_secret" => $config['client_secret'],
         "merchant_id" => $config['merchant_id'],
         "api_base" => $config['api_base'],
      ];
   }

   private function validateResponse($response)
   {
      $status_code = $response->getStatusCode();

      if ($status_code >= 200 && $status_code < 300) {
         $response = json_decode($response->getBody(), true);
         return $response;
      } else {
         $response = json_decode($response->getBody(), true);
         if (isset($response["errors"])) {
            throw new Exception($response["errors"][0]["message"]);
         }
         throw new Exception("Errors node not set in server response");
      }
   }
}
