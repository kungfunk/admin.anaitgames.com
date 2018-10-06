<?php
namespace Domain\Post;

use Domain\Repository;

class CategoriesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Category;
        parent::__construct();
    }

    public function addRelationShips()
    {
        $this->query->withCount('posts');
        return $this;
    }
}
