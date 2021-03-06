<?php
namespace App\ThirdParty\Api\Response\Stripe;

use App\ThirdParty\Api\Response\AbstractResponse;

class StripeChargeResponse extends AbstractResponse
{
    public $id;
    public $status;

    /**
     * @param $response
     */
    public function mapResponse($response)
    {
        $this->id = $response->id;
        $this->status = $response->status;
    }
}