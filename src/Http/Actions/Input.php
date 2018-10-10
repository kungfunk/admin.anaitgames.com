<?php
namespace Http\Actions;

abstract class Input
{
    const MINIMUM_ID = 1;

    const PARAM_PAGE = 'page';
    const PARAM_SEARCH = 'search';
    const PARAM_LIMIT = 'limit';
    const PARAM_ORDER_DIRECTION = 'order_direction';
    const PARAM_ORDER_FIELD = 'order_field';

    const ORDER_DIRECTION_WHITELIST = [
        'desc',
        'asc'
    ];

    const DEFAULT_ORDER_DIRECTION = 'desc';

    public $data = [];

    public function __construct($data)
    {
        $this->data = array_replace($this->defaults, array_intersect_key($data, $this->defaults));
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function getFilledData()
    {
        return array_filter($this->data, 'strlen');
    }

    public function getOrderFields()
    {
        return [$this->order_field, $this->order_direction];
    }
}
