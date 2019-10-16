<?php
namespace App\Stripe\ApiOperations;

Use App\Facade\StripeSourceFacade;
use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;

require '../vendor/autoload.php';

$createData = [
    "type" => "ach_credit_transfer",
    "currency" => "usd",
    "owner" => [
        "email" => "martin.ashcroft1978@gmail.com"
    ]
];

$updateData = [
    "owner" => [
        "name" => "Martin Ashcroft"
    ]
];

try {
    $stripeFacade = new StripeSourceFacade(new StripeSourceResponse);
    $response = $stripeFacade->create($createData);
    var_dump($response);

    $id = $response->id;
    $response = $stripeFacade->update($id, $updateData);
    var_dump($response);


} catch (\Exception $e) {
    echo $e->getMessage();
}

