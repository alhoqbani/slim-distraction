<?php

namespace App\Services;

class ProductHunt extends ServiceAbstract
{
    
    public function get($limt = 10)
    {
        $response = $this->client->get('https://api.producthunt.com/v1/posts?access_token=' . getenv('PRODUCT_HUNT_TOKEN'));

        return json_decode($response->getBody())->posts;
        
    }
}