<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\CategoriesRepository;

class GetCategoriesWithPostCount implements CommandInterface
{
    private $categoriesRepository;

    public function __construct()
    {
        $this->categoriesRepository = new CategoriesRepository;
    }

    public function run()
    {
        $this->categoriesRepository->newQuery();
        $this->categoriesRepository->addRelationShips();

        return $this->categoriesRepository->get();
    }
}
