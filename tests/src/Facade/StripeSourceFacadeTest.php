<?php

use App\ThirdParty\Api\Response\Stripe\StripeSourceResponse;
use PHPUnit\Framework\TestCase;
use Stripe\Source;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class StripeSourceFacadeTest extends TestCase
{
    private $dummyMethod;

    public function setUp()
    {

    }

    public function testShouldReturnCreateResponse()
    {

        $createParams = [
            "type" => "card",
            "currency" => 'usd',
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

        $expectedResponse = json_encode(
            [
                'id' => 'src_1FUvHlBDsLpw4EK6Lmba6lch',
                'type' => 'card',
                'currency' => 'usd',
                'ownerEmail' => 'martin.ashcroft1978@gmail.com',
                'ownerName' => NULL,
                'customer' => NULL,
                'card' =>
                    array (
                        'exp_month' => 10,
                        'exp_year' => 2020,
                        'last4' => '4242',
                        'country' => 'US',
                        'brand' => 'Visa',
                        'funding' => 'credit',
                        'fingerprint' => '6mCVVkCfkIInvNOm',
                        'three_d_secure' => 'optional',
                        'name' => NULL,
                        'address_line1_check' => NULL,
                        'address_zip_check' => NULL,
                        'cvc_check' => NULL,
                        'tokenization_method' => NULL,
                        'dynamic_last4' => NULL,
                    ),
                'status' => 'chargeable',
                'amount' => NULL,
            ]
        );
        $source = $this->createMock(Source::class);
        $source->method('create')->willReturn($expectedResponse);
        $stripeApiResponse = $source->create($createParams);

        echo $stripeApiResponse;
        die();

        $this->stripeSourceResponse->mapResponse($stripeApiResponse);
        return $this->stripeSourceResponse;
    }

    private function getPostcodes($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
    }
}