<?php
namespace Http\Actions;

abstract class Input
{
    const MINIMUM_ID = 1;

    const PARAM_SEARCH = 'search';
    const PARAM_LIMIT = 'limit';
    const PARAM_OFFSET = 'offset';
    const PARAM_ORDER = 'order';
    const PARAM_ORDER_BY = 'order_by';

    const ORDER_DIRECTION_WHITELIST = [
        'desc',
        'asc'
    ];

    const DEFAULT_LIMIT = 100;
    const DEFAULT_ORDER = 'desc';
    const DEFAULT_OFFSET = 0;
}
