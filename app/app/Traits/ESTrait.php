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

    protected function indexDocument($document)
    {
        $client = $this->setupClient();
        $params = $this->getParams($document);

        return $client->index($params);
    }

    protected function searchDocument($params)
    {
        $client = $this->setupClient();

        return $client->search($params);
    }

    protected function deleteDocument()
    {
        $client = $this->setupClient();
    }


    protected function getParams($document)
    {
        $params = [
            'body' => [
                'identifier' => $document->identifier,
                'type' => $document->type,
                'type_identifier' => $document->type_identifier,
                'year' => (int)$document->year,
                'lang' => $document->lang,
                'ecli' => $document->ecli,
                'src' => $document->src,
                'meta' => null,
                'text' => $document->text,
                'ref' => $document->ref,
                'link' => $document->link,
            ],
                'index' => 'ecli',
                'type' => 'documents',
                'id' => $document->id,
            ];

        return $params;
    }
}
