<?php
namespace Http\Helpers;

use JasonGrimes\Paginator;

class Pagination extends Paginator
{
    public function __construct()
    {
    }

    public function setup($totalItems, $itemsPerPage, $currentPage)
    {
        parent::__construct($totalItems, $itemsPerPage, $currentPage, '');
    }

    public function getPages()
    {
        $pages = parent::getPages();

        return array_map(function ($page) {
            unset($page['url']);
            return $page;
        }, $pages);
    }
}
