<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class baseTest extends TestCase
{
    /** @test */
    public function redirectionTest()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function baseApiTest()
    {
        $response = $this->call('GET', '/api/v1/ECLI/BE');
        $this->assertEquals(200, $response->status());
    }
}
