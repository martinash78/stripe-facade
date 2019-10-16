<?php
namespace App\Dummy;

use \Exception;

class DummyMethods
{
    public static function dummyError()
    {
        throw new Exception(__METHOD__ . ' Exception thrown');
    }
}