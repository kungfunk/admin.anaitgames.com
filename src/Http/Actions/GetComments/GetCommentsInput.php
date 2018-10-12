<?php
namespace Http\Actions\GetComments;

use Http\Actions\Input;
use Infrastructure\Exceptions\BadInputException;
use Models\Comment;

class GetCommentsInput extends Input
{
    protected $defaults = [
        'user_id' => null,
        'post_id' => null,
        self::PARAM_PAGE => 1,
        self::PARAM_SEARCH => null,
        self::PARAM_ORDER_FIELD => Comment::DEFAULT_ORDER_FIELD,
        self::PARAM_ORDER_DIRECTION => self::DEFAULT_ORDER_DIRECTION,
    ];

    public function validate()
    {
        $this->isValidOrder($this->order_direction, $this->order_field);
    }

    private function isValidOrder($orderDirection, $orderField)
    {
        if (!in_array($orderField, Comment::ORDER_FIELD_WHITELIST) ||
            !in_array($orderDirection, $this::ORDER_DIRECTION_WHITELIST)
        ) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }
}
