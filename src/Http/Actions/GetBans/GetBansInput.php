<?php
namespace Http\Actions\GetBans;

use Http\Actions\Input;
use Infrastructure\Exceptions\BadInputException;
use Models\Ban;

class GetBansInput extends Input
{
    protected $defaults = [
        'user_id' => null,
        self::PARAM_PAGE => 1,
        self::PARAM_ORDER_FIELD => Ban::DEFAULT_ORDER_FIELD,
        self::PARAM_ORDER_DIRECTION => self::DEFAULT_ORDER_DIRECTION,
    ];

    public function validate()
    {
        $this->isValidOrder($this->order_direction, $this->order_field);
    }

    private function isValidOrder($orderDirection, $orderField)
    {
        if (!in_array($orderField, Ban::ORDER_FIELD_WHITELIST) ||
            !in_array($orderDirection, $this::ORDER_DIRECTION_WHITELIST)
        ) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }
}
