<?php

namespace Tests\Feature;

class HomepageTest extends FeatureSetup
{
    public function testHomepageGet()
    {
        $response = $this->get('/');

        $response->assertStatus(204);
    }
}
