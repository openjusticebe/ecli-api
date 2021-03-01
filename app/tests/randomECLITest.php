<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Document;

class randomECLITest extends TestCase
{

    /** @test */
    public function randomAccessTest()
    {
        $documents = Document::inRandomOrder()->take(10)->get();
        foreach ($documents as $doc) {
            $response = $this->call('GET', '/api/v1/ECLI' . $doc->ref);
            $response->assertStatus(200);
            $response->assertSee($doc->ecli);
        }
    }
}
