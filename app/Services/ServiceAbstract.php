<?php

namespace App\Services;

use GuzzleHttp\Client;

abstract class ServiceAbstract
{
    
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;
    
    /**
     * ServiceAbstract constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    abstract public function get($limit);
}