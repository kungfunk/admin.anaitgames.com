<?php
namespace Domain\Post;

class TagsRepository
{
    private $tags_model;

    public function __construct(Tag $tag)
    {
        $this->tags_model = $tag;
    }

    public function getAll()
    {
        return $this->tags_model->all();
    }
}