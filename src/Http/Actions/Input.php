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

    const DEFAULT_LIMIT = 100;
    const DEFAULT_ORDER_DIRECTION = 'desc';

    public $data = [];

    public function __get($name)
    {
        return $this->data[$name];
    }
}
