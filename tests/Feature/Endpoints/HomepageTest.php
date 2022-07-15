<?php

namespace Tests\Feature;


class HomepageTest extends FeatureSetup
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(204);
    }
}
