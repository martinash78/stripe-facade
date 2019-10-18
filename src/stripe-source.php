<?php
namespace App\Stripe\ApiOperations;

Use App\Facade\StripeSourceFacade;
use App\ThirdParty\Api\Response\Stripe\StripeChargeResponse;
use App\ThirdParty\Api\Response\Stripe\StripeRefundResponse;
use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;

require '../vendor/autoload.php';

$config = parse_ini_file("../config/stripe.ini");
$customerId = $config['customer_id'];
$amount = $config['amount'];
$currency = $config['currency'];

$createParams = [
    "type" => "card",
    "currency" => $currency,
    "owner" => [
        "email" => "martin.ashcroft1978@gmail.com"
    ],
    'card' => [
        'address_city' => null,
        'address_country' => null,
        'address_line1' => null,
        'address_line1_check' => null,
        'address_line2' => null,
        'address_state' => null,
        'address_zip' => null,
        'address_zip_check' => null,
        'cvc_check' => null,
        'dynamic_last4' => null,
        'exp_month' => 10,
        'exp_year' => 2020,
        'metadata' => [],
        'name' => null,
        'tokenization_method' => null,
        'number' => 4242424242424242
    ]
];

$updateParams = [
    "owner" => [
        "name" => "Martin Ashcroft"
    ]
];

/**
 * @param $response
 * @return false|string
 */
function printResponse($response)
{
    return json_encode($response, JSON_PRETTY_PRINT);
}


?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php

try {
    $stripeSourceResponse = new StripeSourceResponse();
    $stripeChargeResponse = new StripeChargeResponse();
    $stripeRefundResponse = new StripeRefundResponse();
    $stripeFacade = new StripeSourceFacade($stripeSourceResponse, $stripeChargeResponse, $stripeRefundResponse);
    $response = $stripeFacade->create($createParams);

    /**
     * Create Source
     */
    echo '<h5>Response: Create</h5>';
    echo printResponse($response);

    $sourceId = $response->id;

    /**
     * Retrieve Source
     */
    echo '<hr /><h5>Response: Retrieve Source ID "' . $sourceId . ' </h5>';
    $response = $stripeFacade->retrieve($sourceId);
    echo printResponse($response);

    /**
     * Update Source
     */
    echo '<hr /><h5>Response: Update Source ID "' . $sourceId . ' </h5>';
    $response = $stripeFacade->update($sourceId, $updateParams);
    echo printResponse($response);

    $attachParams = [
        'source' => $sourceId
    ];

    /**
     * Attach a Source
     */
    echo '<hr /><h5>Response: Attach Customer ID "' . $customerId . '" to Source ID "' . $sourceId . ' </h5>';
    $response = $stripeFacade->attach($attachParams, $customerId);
    echo printResponse($response);

    $chargeParams = [
        'amount' => $amount,
        'currency' => $currency,
        'customer' => $customerId,
        'source' => $sourceId,
    ];

    /**
     * Charge the Source
     */
    echo '<hr /><h5>Response: Charge the Source ID "' . $sourceId . ' </h5>';
    $response = $stripeFacade->charge($chargeParams);
    echo printResponse($response);

    /**
     * Refund the charge
     */
    $chargeId = $response->id;
    $refundParams = [
        'charge' => $chargeId,
        'amount' => $amount
    ];
    echo '<hr /><h5>Response: Refund the Charge ID "' . $chargeId . ' </h5>';
    $response = $stripeFacade->refund($refundParams);
    echo printResponse($response);

    /**
     * Detach a Source
     */
    echo '<hr /><h5>Response: Detach Customer ID "' . $customerId . '" to Source ID "' . $sourceId . ' </h5>';
    $response = $stripeFacade->detach($sourceId, $customerId);
    echo printResponse($response);


} catch (\Exception $e) {
    echo $e->getMessage();
}
?>
</div>

</body>
</html>

