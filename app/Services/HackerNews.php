<?php

namespace App\Services;

class HackerNews extends ServiceAbstract
{
    
    public function get($limt = 10)
    {
        $response = $this->client->get('https://hacker-news.firebaseio.com/v0/topstories.json');
        $ids = array_slice(json_decode($response->getBody()), 0, $limt);
        
        $stories = [];
        foreach ($ids as $id) {
            $response = $this->client->get('https://hacker-news.firebaseio.com/v0/item/' . $id . '.json');
            $stories[] = json_decode($response->getBody());
        }
        return $stories;
    }
}