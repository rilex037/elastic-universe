<?php

use App\Models\Post;
use Tests\Unit\UnitSetup;

class PostTest extends UnitSetup
{
    public function testGetTypeName()
    {
        $post = new Post();
        $this->assertEquals('posts', $post->getTypeName());
    }
}
