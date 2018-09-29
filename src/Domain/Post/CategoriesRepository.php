<?php
namespace Domain\Post;

class CategoriesRepository
{
    private $categoryModel;
    private $query;

    public function __construct()
    {
        $this->categoryModel = new Category;
        $this->reset();
    }

    private function reset()
    {
        $this->query = $this->categoryModel->query();
    }

    public function get($resetAfterQuery = true)
    {
        $result = $this->query->get();

        if ($resetAfterQuery) {
            $this->reset();
        }

        return $result;
    }

    public function count($resetAfterQuery = true)
    {
        $result = $this->query->count();

        if ($resetAfterQuery) {
            $this->reset();
        }

        return $result;
    }

    public function addRelationShips()
    {
        $this->query->withCount('posts');
        return $this;
    }
}
