<?php

namespace App\Services;

use App\Cache\CacheInterface;
use App\Transformers\HackerNewsTransformer;
use App\Transformers\ProdcutHuntTransformer;
use App\Transformers\RedditTransformer;
use GuzzleHttp\Client;

class ServiceFactory
{
    
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    
    protected $enabledServices = [
        'reddit',
        'producthunt',
        'hackernews',
    ];
    /**
     * @var \App\Cache\CacheInterface
     */
    private $cache;
    
    
    /**
     * ServiceFactory constructor.
     *
     * @param \GuzzleHttp\Client        $client
     * @param \App\Cache\CacheInterface $cache
     */
    public function __construct(Client $client, CacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }
    
    public function get($service, $limit = 10)
    {
        if (method_exists($this, $service) && $this->serviceIsEnabled($service)) {
            return $this->sortResponseByTimeStamp(
                $this->{$service}($limit)
            );
        }
        
        return [];
    }
    
    protected function hackernews($limit = 10)
    {
        $data = $this->cache->remember('hackernews', 10, function () use ($limit) {
            return json_encode((new HackerNews($this->client))->get($limit));
        });
        
        return (new HackerNewsTransformer(json_decode($data)))->create();
    }
    
    protected function reddit($limit = 10)
    {
        $data = $this->cache->remember('reddit', 10, function () use ($limit) {
            return json_encode((new Reddit($this->client))->get($limit));
        });
        
        return (new RedditTransformer(json_decode($data)))->create();
    }
    
    protected function producthunt($limit = 10)
    {
        $data = $this->cache->remember('producthunt', 10, function () use ($limit) {
            return json_encode((new ProductHunt($this->client))->get($limit));
        });
        
        return (new ProdcutHuntTransformer(json_decode($data)))->create();
    }
    
    public function sortResponseByTimeStamp(array $data)
    {
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });
        
        return $data;
    }
    
    protected function serviceIsEnabled($service)
    {
        return in_array($service, $this->enabledServices);
    }
}