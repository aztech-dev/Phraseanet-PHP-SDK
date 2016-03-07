<?php

namespace PhraseanetSDK\Recorder\Filters;

class LimitFilter implements FilterInterface
{
    private $limit;

    public function __construct($limit = 400)
    {
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(array &$data)
    {
        $data = array_slice($data, 0 - $this->limit, null, true);
    }
}
