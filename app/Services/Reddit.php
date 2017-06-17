<?php

namespace App\Services;

class Reddit extends ServiceAbstract
{
    
    public function get($limt = 10)
    {
        $response = $this->client->get('https://www.reddit.com/r/popular.json?limit=' . $limt, [
            'headers' => ['User-Agent' => 'DistractApi'],
        ]);
        
        return json_decode($response->getBody())->data->children;
        
    }
}