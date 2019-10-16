<?php
namespace App\Facade;

use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;
use Stripe\Stripe;
use Stripe\Source;
use \Stripe\Exception\ApiErrorException;


/**
 * Class StripeSourceFacade
 * @package Facade
 */
class StripeSourceFacade
{
    private $apiKey;
    private $response;

    public function __construct(StripeSourceResponse $response)
    {
        $config = parse_ini_file("../config/stripe.ini");
        $this->response = $response;
        $this->apiKey = Stripe::setApiKey($config['key']);
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
     * @param $id
     * @param $data
     * @return StripeSourceResponse
     * @throws ApiErrorException
     */
    public function update($id, $data)
    {
        $stripeApiResponse = Source::update($id, $data);
        $this->response->mapResponse($stripeApiResponse);
        return $this->response;
    }

}