<?php

use App\Models\Todo;
use Tests\Unit\UnitSetup;

class TodoTest extends UnitSetup
{
    public function testGetTypeName()
    {
        $todo = new Todo();
        $this->assertEquals('todos', $todo->getTypeName());
    }
}
