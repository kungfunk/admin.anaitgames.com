<?php
namespace Http\Actions;

abstract class Input
{
    const MINIMUM_ID = 1;

    const PARAM_PAGE = 'page';
    const PARAM_SEARCH = 'search';
    const PARAM_LIMIT = 'limit';
    const PARAM_ORDER_DIRECTION = 'order';
    const PARAM_ORDER_FIELD = 'order_by';

    const ORDER_DIRECTION_WHITELIST = [
        'desc',
        'asc'
    ];

    const DEFAULT_LIMIT = 100;
    const DEFAULT_ORDER_DIRECTION = 'desc';
}
