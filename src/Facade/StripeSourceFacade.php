<?php
namespace App\Facade;

use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;
use App\ThirdParty\Api\Response\Stripe\StripeChargeResponse;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Source;
use Stripe\Charge;
use \Stripe\Exception\ApiErrorException;


/**
 * Class StripeSourceFacade
 * @package Facade
 */
class StripeSourceFacade
{
    private $apiKey;
    private $response;

    public function __construct($response)
    {
        $config = parse_ini_file("../config/stripe.ini");
        $this->setResponse($response);
        $this->apiKey = Stripe::setApiKey($config['key']);
    }

    public function setResponse($class)
    {
        $this->response = new $class();
    }

    /**
     * @param $data
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function create($data) : StripeSourceResponse
    {
        $stripeApiResponse = Source::create($data);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

    /**
     * @param $sourceId
     * @param $params
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function update($sourceId, $params) : StripeSourceResponse
    {
        $stripeApiResponse = Source::update($sourceId, $params);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

    /**
     * @param $sourceId
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function retrieve($sourceId) : StripeSourceResponse
    {
        $stripeApiResponse = Source::retrieve($sourceId);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

    /**
     * @param $params
     * @param $customerId
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function attach($params, $customerId) : StripeSourceResponse
    {
        $stripeApiResponse = Customer::createSource($customerId, $params);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

    /**
     * @param $sourceId
     * @param $customerId
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function detach($sourceId, $customerId) : StripeSourceResponse
    {
        $stripeApiResponse = Customer::deleteSource($customerId, $sourceId);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

    public function charge($params) : StripeChargeResponse
    {
        $stripeApiResponse = Charge::create($params);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

}