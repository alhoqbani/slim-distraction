<?php

namespace App\Transformers;

class ProdcutHuntTransformer extends AbstractTransformer
{
    
    public function transform(\stdClass $payLoad)
    {
        return [
            'title'     => $payLoad->name,
            'link'      => $payLoad->discussion_url,
            'timestamp' => strtotime($payLoad->created_at),
            'service'   => 'ProductHunt',
        ];
    }
}
