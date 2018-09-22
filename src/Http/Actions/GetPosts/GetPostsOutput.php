<?php
namespace Http\Actions\GetPosts;

use Illuminate\Database\Eloquent\Collection;
use Http\Helpers\Pagination;

class GetPostsOutput
{
    public $posts;
    public $totalPostsNumber;
    public $categories;
    public $writers;
    public $page;
    public $pagination;
    public $paginationParameters;
    public $statusFilters;
    public $baseUrl;

    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;
    }

    public function setTotalPostsNumber(int $totalPostsNumber)
    {
        $this->totalPostsNumber = $totalPostsNumber;
    }

    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    public function setWriters(Collection $writers)
    {
        $this->writers = $writers;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function setStatusFilters(array $statusFilters)
    {
        $this->statusFilters = $statusFilters;
    }

    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function setPaginationParameters(array $paginationParameters)
    {
        $this->paginationParameters = $paginationParameters;
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}
