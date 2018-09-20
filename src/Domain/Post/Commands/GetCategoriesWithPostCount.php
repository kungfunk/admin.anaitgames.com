<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\CategoriesRepository;

class GetCategoriesWithPostCount implements CommandInterface
{
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function run()
    {
        return $this->categoriesRepository->getAllWithPostCount();
    }
}
