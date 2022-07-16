<?php

namespace Tests\Unit;

use Tests\TestCase;

abstract class UnitSetup extends TestCase
{
    protected static $initialized = FALSE;

    protected function setUp(): void
    {
        parent::setup();
        if (!self::$initialized) {
            echo 'RUNNING UNIT TESTS...' . PHP_EOL;
            self::$initialized = TRUE;
        }
    }
}
