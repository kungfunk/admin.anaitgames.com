<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Input;
use Infrastructure\Exceptions\BadInputException;
use Domain\Post\Post;

class GetPostsInput extends Input
{
    const STATUS_WHITELIST = [
        Post::STATUS_DRAFT,
        Post::STATUS_PUBLISHED,
        Post::STATUS_TRASH
    ];

    protected $defaults = [
        'category_id' => null,
        'user_id' => null,
        'status' => null,
        self::PARAM_PAGE => 1,
        self::PARAM_SEARCH => null,
        self::PARAM_ORDER_FIELD => Post::DEFAULT_ORDER_FIELD,
        self::PARAM_ORDER_DIRECTION => self::DEFAULT_ORDER_DIRECTION,
    ];

    public function validate()
    {
        $this->isValidStatus($this->status);
        $this->isValidOrder($this->order_direction, $this->order_field);
    }

    private function isValidStatus($status)
    {
        if ($status && !in_array($status, $this::STATUS_WHITELIST)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    private function isValidOrder($orderDirection, $orderField)
    {
        if (!in_array($orderField, Post::ORDER_FIELD_WHITELIST) ||
            !in_array($orderDirection, $this::ORDER_DIRECTION_WHITELIST)
        ) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }
}
