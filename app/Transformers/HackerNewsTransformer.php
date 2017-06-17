<?php

namespace App\Transformers;

class HackerNewsTransformer extends AbstractTransformer
{
    
    public function transform(\stdClass $payLoad)
    {
        return [
            'title'     => $payLoad->title,
            'link'      => $payLoad->url ?? 'https://news.ycombinator.com/item?id=' . $payLoad->id,
            'timestamp' => $payLoad->time,
            'service'   => 'Hacker News',
        ];
    }
}
