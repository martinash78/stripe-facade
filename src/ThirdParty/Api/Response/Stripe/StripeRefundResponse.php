<?php
namespace App\ThirdParty\Api\Response\Stripe;

use App\ThirdParty\Api\Response\AbstractResponse;

class StripeRefundResponse extends AbstractResponse
{
    public $id;
    public $amount;
    public $status;

    /**
     * @param $response
     */
    public function mapResponse($response)
    {
        $this->id = $response->id;
        $this->amount = $response->amount;
        $this->status = $response->status;
    }
}