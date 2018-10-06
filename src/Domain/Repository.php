<?php
namespace Domain;

abstract class Repository
{
    protected $model;
    protected $query;

    protected function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->query = $this->model->query();
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
}
