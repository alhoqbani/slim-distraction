<?php

namespace App\Services;

use App\Transformers\HackerNewsTransformer;
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
            return $this->sortResponseByTimeStamp(
                $this->{$service}($limit)
            );
        }
    }
    
    protected function hackernews($limit = 10)
    {
        $data = (new HackerNews($this->client))->get($limit);
        
        return (new HackerNewsTransformer($data))->create();
    }
    
    public function sortResponseByTimeStamp(array $data)
    {
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });
        
        return $data;
    }
}