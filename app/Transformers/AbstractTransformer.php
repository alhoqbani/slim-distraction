<?php

namespace App\Transformers;

abstract class AbstractTransformer
{
    
    /**
     * @var array
     */
    private $data;
    
    /**
     * AbstractTransformer constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    abstract public function transform(\stdClass $payLoad);
    
    
    public function create()
    {
        return array_map(function ($item) {
            return $this->transform($item);
        }, $this->data);
    }
}