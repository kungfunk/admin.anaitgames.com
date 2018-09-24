<?php
namespace Domain\Post;

class CategoriesRepository
{
    private $categoryModel;
    private $query;

    public function __construct()
    {
        $this->categoryModel = new Category;
    }

    public function newQuery()
    {
        $this->query = $this->categoryModel->query();
    }

    public function get()
    {
        return $this->query->get();
    }

    public function addRelationShips()
    {
        return $this->query->withCount('posts');
    }
}
