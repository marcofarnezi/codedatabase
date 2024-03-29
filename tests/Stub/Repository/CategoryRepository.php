<?php
namespace CodePress\CodeDatabase\Tests\Stub\Repository;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeDatabase\Tests\Stub\Model\Category;

class CategoryRepository extends AbstractRepository
{
    public function model()
    {
        return Category::class;
    }
}