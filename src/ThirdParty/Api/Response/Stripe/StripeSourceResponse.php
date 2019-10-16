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
    }
}