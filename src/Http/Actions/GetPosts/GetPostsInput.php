<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Input;
use Psr\Http\Message\ServerRequestInterface as Request;
use Http\Actions\BadInputException as BadInputException;
use Domain\Post\Post as Post;

class GetPostsInput extends Input
{
    const PARAM_TYPE = 'categoryId';
    const PARAM_STATUS = 'status';
    const PARAM_TAGS = 'tags';

    const STATUS_WHITELIST = [
        Post::STATUS_DRAFT,
        Post::STATUS_PUBLISHED,
        Post::STATUS_TRASH
    ];

    const ORDER_FIELD_WHITELIST = Post::ORDER_FIELD_WHITELIST;
    const DEFAULT_STATUS = Post::STATUS_PUBLISHED;
    const DEFAULT_LIMIT = Post::DEFAULT_LIMIT;
    const DEFAULT_ORDER_BY = Post::DEFAULT_ORDER_FIELD;

    const MAX_LIMIT = 50;
    const TAG_DELIMITER = '|';

    public $search;
    public $categoryId;
    public $status;
    public $tags;
    public $orderField;
    public $orderDirection;
    public $limit;
    public $offset;

    public function __construct(Request $request)
    {
        $this->search = $request->getQueryParam($this::PARAM_SEARCH, $default = null);
        $this->categoryId = $request->getQueryParam($this::PARAM_TYPE, $default = null);
        $this->status = $request->getQueryParam($this::PARAM_STATUS, $default = $this::DEFAULT_STATUS);
        $this->orderField = $request->getQueryParam($this::PARAM_ORDER_BY, $default = $this::DEFAULT_ORDER_BY);
        $this->orderDirection = $request->getQueryParam($this::PARAM_ORDER, $default = $this::DEFAULT_ORDER);
        $this->offset = $request->getQueryParam($this::PARAM_OFFSET, $default = $this::DEFAULT_OFFSET);
        $this->limit = $request->getQueryParam($this::PARAM_LIMIT, $default = $this::DEFAULT_LIMIT);

        $_tags = $request->getQueryParam($this::PARAM_TAGS, $default = null);
        $this->tags = !is_null($_tags) ? explode($this::TAG_DELIMITER, $_tags) : [];

        $this->isValidLimit($this->limit);
        $this->isValidOffset($this->offset);
        $this->isValidStatus($this->status);
        $this->isValidOrder($this->orderDirection, $this->orderField);
    }

    private function isValidLimit($limit)
    {
        if ($limit >= $this::MAX_LIMIT) {
            throw new BadInputException(BadInputException::LIMIT_EXCEEDED);
        }
    }

    private function isValidOffset($offset)
    {
        if ($offset < $this::DEFAULT_OFFSET) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    private function isValidStatus($status)
    {
        if (!in_array($status, $this::STATUS_WHITELIST)) {
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
