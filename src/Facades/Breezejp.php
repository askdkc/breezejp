<?php

namespace Askdkc\Breezejp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Askdkc\Breezejp\Breezejp
 */
class Breezejp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Askdkc\Breezejp\Breezejp::class;
    }
}
