<?php


namespace App\Services\Entity;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryService extends AbstractEntityService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry);
        $this->categoryRepo = $managerRegistry->getRepository(Category::class);
    }

    /**
     * @param string $title
     * @return Category|null
     */
    public function getCategoryByTitle(string $title): ?Category{
        return $this->categoryRepo->findOneByTitle($title);
    }
}