<?php

namespace App\Traits;

use App\Models\Document;
use Elasticsearch\ClientBuilder;

trait ESTrait
{
    protected function setupClient()
    {
        $hosts = ['http://' . env('ELASTIC_HOST', 'localhost') . ':9200'];
        $clientBuilder = ClientBuilder::create();   // Instantiate a new ClientBuilder
        $clientBuilder->setHosts($hosts);           // Set the hosts
        
        return $clientBuilder->build();
    }

    protected function indexDocument($params)
    {
        $client = $this->setupClient();
        return $client->index($params);
    }

    protected function searchDocument()
    {
        $client = $this->setupClient();
    }

    protected function deleteDocument()
    {
        $client = $this->setupClient();
    }
}
