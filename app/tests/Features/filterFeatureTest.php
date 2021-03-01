<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class filterFeatureTest extends TestCase
{
    /** @test */
    public function filterDocsTest()
    {
        $response = $this->call(
            'POST',
            '/api/v1/ECLI/BE/RSCE/docsFilter',
            [
            'year' => ['2010', '2011'],
            'type' => ['ARR', 'DEC'],
            'lang' => ['french', 'undefined']
        ]
        );

        $response->assertStatus(200);
    }
}
