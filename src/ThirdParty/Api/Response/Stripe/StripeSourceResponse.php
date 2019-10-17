<?php
namespace App\ThirdParty\Api\Response\Stripe;

use App\ThirdParty\Api\Response\AbstractResponse;

class StripeSourceResponse extends AbstractResponse
{
    public $id;
    public $type;
    public $currency;
    public $ownerEmail;
    public $ownerName;
    public $customer;
    public $card;
    public $status;
    public $amount;

    /**
     * @param $response
     */
    public function mapResponse($response)
    {
        $this->id = $response->id;
        $this->type = $response->type;
        $this->currency = $response->currency;
        $this->ownerName = $response->owner->name;
        $this->ownerEmail = $response->owner->email;
        $this->customer = $response->customer;
        $this->card = $response->card;
        $this->status = $response->status;
        $this->amount = $response->amount;
    }
}