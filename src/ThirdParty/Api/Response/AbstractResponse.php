<?php
namespace App\ThirdParty\Api\Response;

abstract class AbstractResponse
{
    abstract protected function mapResponse($response);

}