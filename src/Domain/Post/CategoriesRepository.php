<?php
namespace Domain\Post;

class CategoriesRepository
{
    private $categories_model;

    public function __construct(Category $category)
    {
        $this->categories_model = $category;
    }

    public function getAll()
    {
        return $this->categories_model->all();
    }
}