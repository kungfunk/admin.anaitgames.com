<?php
namespace Domain\Post;

use Domain\Repository;

class TagsRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Tag;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
