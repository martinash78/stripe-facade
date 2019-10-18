<?php
namespace App\Facade;

use App\ThirdParty\Api\Response\Stripe\StripeRefundResponse;
use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;
use App\ThirdParty\Api\Response\Stripe\StripeChargeResponse;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Source;
use Stripe\Charge;
use Stripe\Refund;
use \Stripe\Exception\ApiErrorException;


/**
 * Class StripeSourceFacade
 * @package Facade
 */
class StripeSourceFacade
{
    private $apiKey;
    private $stripeSourceResponse;
    private $stripeChargeResponse;
    private $stripeRefundResponse;

    /**
     * StripeSourceFacade constructor.
     * @param StripeSourceResponse $stripeSourceResponse
     * @param StripeChargeResponse $stripeChargeResponse
     * @param StripeRefundResponse $stripeRefundResponse
     */
    public function __construct(
        StripeSourceResponse $stripeSourceResponse,
        StripeChargeResponse $stripeChargeResponse,
        StripeRefundResponse $stripeRefundResponse
    )
    {
        $config = parse_ini_file("../config/stripe.ini");
        $this->stripeSourceResponse = $stripeSourceResponse;
        $this->stripeChargeResponse = $stripeChargeResponse;
        $this->stripeRefundResponse = $stripeRefundResponse;
        Stripe::setApiKey($config['key']);
    }

    /**
     * @param $data
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function create($data) : StripeSourceResponse
    {
        $stripeApiResponse = Source::create($data);
        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
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
        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
    }

    /**
     * @param $sourceId
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function retrieve($sourceId) : StripeSourceResponse
    {
        $stripeApiResponse = Source::retrieve($sourceId);
        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
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
        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
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
        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
    }

    /**
     * @param $params
     * @return StripeChargeResponse
     * @throws ApiErrorException
     */
    public function charge($params) : StripeChargeResponse
    {
        $stripeApiResponse = Charge::create($params);
        $this->stripeChargeResponse->mapResponse($stripeApiResponse);
        return $this->stripeChargeResponse;
    }

    /**
     * @param $params
     * @return StripeRefundResponse
     * @throws ApiErrorException
     */
    public function refund($params) : StripeRefundResponse
    {
        $stripeApiResponse = Refund::create($params);
        $this->stripeRefundResponse->mapResponse($stripeApiResponse);
        return $this->stripeRefundResponse;
    }

}