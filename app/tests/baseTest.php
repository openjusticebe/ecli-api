<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class baseTest extends TestCase
{
    /** @test */
    public function redirectionTest()
    {
        $this->get('/');
        $this->seeStatusCode(302);
    }

    /** @test */
    public function baseApiTest()
    {
        $this->get('/api/v1/ECLI/BE/');
        $this->seeStatusCode(200);
    }
}
