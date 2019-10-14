<?php
namespace CodePress\CodeDatabase\Tests\CodeDatabase;


use CodePress\CodeDatabase\Contracts\CriteriaInterface;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use CodePress\CodeDatabase\Tests\Stub\Criteria\FindByNameAndDescription;
use CodePress\CodeDatabase\Tests\Stub\Repository\CategoryRepository;
use \CodePress\CodeDatabase\Tests\Stub\Model\Category;
use Illuminate\Database\Eloquent\Builder;

class FindByNameAndDescriptionTest extends AbstractTestCase
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * @var FindByNameAndDescription
     */
    private $criteria;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->repository = new CategoryRepository();
        $this->criteria = new FindByNameAndDescription();
        $this->createCategories();
    }

    private function createCategories()
    {
        Category::create(
            [
                'name' => 'Category 1',
                'description' => 'Description 1'
            ]
        );
        Category::create(
            [
                'name' => 'Category 2',
                'description' => 'Description 2'
            ]
        );
        Category::create(
            [
                'name' => 'Category 3',
                'description' => 'Description 3'
            ]
        );
    }

    public function test_if_instanceof_criteriainrterface()
    {
        $this->assertInstanceOf(CriteriaInterface::class, $this->criteria);
    }

    public function test_if_apply_returns_querybuild()
    {
        $model = $this->repository->model();
        $result = $this->criteria->apply(new $model, $this->repository);
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_if_apply_returns_data()
    {
        $model = $this->repository->model();
        $result = $this->criteria->apply(new $model, $this->repository)->get();
        $this->assertEquals('Category 1', $result->first()->name);
        $this->assertEquals('Description 1', $result->first()->description);
    }
}