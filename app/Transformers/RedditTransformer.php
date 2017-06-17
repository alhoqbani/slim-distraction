<?php

namespace App\Transformers;

class RedditTransformer extends AbstractTransformer
{
    
    public function transform(\stdClass $payLoad)
    {
        
        return [
            'title'     => $payLoad->data->title,
            'link'      => 'https://www.reddit.com' . $payLoad->data->permalink,
            'timestamp' => $payLoad->data->created_utc,
            'service'   => 'Reddit',
        ];
    }
}
