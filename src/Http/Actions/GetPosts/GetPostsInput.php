<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Input;
use Psr\Http\Message\ServerRequestInterface as Request;
use Infrastructure\Exceptions\BadInputException;
use Domain\Post\Post;

class GetPostsInput extends Input
{
    const PARAM_TYPE = 'category_id';
    const PARAM_AUTHOR = 'user_id';
    const PARAM_STATUS = 'status';
    const PARAM_TAGS = 'tags';

    const STATUS_WHITELIST = [
        Post::STATUS_DRAFT,
        Post::STATUS_PUBLISHED,
        Post::STATUS_TRASH
    ];

    const ORDER_FIELD_WHITELIST = Post::ORDER_FIELD_WHITELIST;
    const DEFAULT_STATUS = Post::STATUS_PUBLISHED;
    const DEFAULT_ORDER_FIELD = Post::DEFAULT_ORDER_FIELD;

    const TAG_DELIMITER = '|';

    public $page;
    public $search;
    public $categoryId;
    public $userId;
    public $status;
    public $tags;
    public $orderField;
    public $orderDirection;

    public function __construct(Request $request)
    {
        $this->page = $request->getQueryParam($this::PARAM_PAGE, $default = 1);
        $this->search = $request->getQueryParam($this::PARAM_SEARCH, $default = null);
        $this->categoryId = $request->getQueryParam($this::PARAM_TYPE, $default = null);
        $this->userId = $request->getQueryParam($this::PARAM_AUTHOR, $default = null);
        $this->status = $request->getQueryParam($this::PARAM_STATUS, $default = null);
        $this->orderField = $request->getQueryParam($this::PARAM_ORDER_FIELD, $default = $this::DEFAULT_ORDER_FIELD);
        $this->orderDirection = $request->getQueryParam(
            $this::PARAM_ORDER_DIRECTION,
            $default = $this::DEFAULT_ORDER_DIRECTION
        );

        $_tags = $request->getQueryParam($this::PARAM_TAGS, $default = null);
        $this->tags = !is_null($_tags) ? explode($this::TAG_DELIMITER, $_tags) : [];

        $this->isValidStatus($this->status);
        $this->isValidOrder($this->orderDirection, $this->orderField);
    }

    private function isValidStatus($status)
    {
        if ($status && !in_array($status, $this::STATUS_WHITELIST)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    private function isValidOrder($orderDirection, $orderField)
    {
        if (!in_array($orderField, $this::ORDER_FIELD_WHITELIST) ||
            !in_array($orderDirection, $this::ORDER_DIRECTION_WHITELIST)
        ) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }
}
