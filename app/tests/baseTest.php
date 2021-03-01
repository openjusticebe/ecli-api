<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class baseTest extends TestCase
{
    /** @test */
    public function redirectionTest()
    {
        $response = $this->call('GET', '/');
        $response->assertStatus(302);
    }

    /** @test */
    public function baseApiTest()
    {
        $response = $this->call('GET', '/api/v1/ECLI/BE');
        $response->assertStatus(200);
        $response->assertSee('OpenJustice.be');
        $response->assertSee('v1');
    }
}
