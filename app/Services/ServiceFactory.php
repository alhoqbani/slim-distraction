<?php

namespace App\Services;

use GuzzleHttp\Client;

class ServiceFactory
{
    
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    
    
    /**
     * ServiceFactory constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function get($service, $limit = 10)
    {
        if (method_exists($this, $service)) {
            return $this->{$service}($limit);
        }
    }
    
    protected function hackernews($limit = 10)
    {
        return (new HackerNews($this->client))->get($limit);
    }
}