<?php
namespace CodePress\CodeDatabase\Tests\CodeDatabase;


use CodePress\CodeCategory\Models\Category;
use CodePress\CodeDatabase\Contracts\CriteriaInterface;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use CodePress\CodeDatabase\Tests\Stub\Repository\CategoryRepository;
use Illuminate\Database\Query\Builder;

class CriteriaInterfaceTest extends AbstractTestCase
{
    public function test_should_apply()
    {
        $mockQueryBuilder = \Mockery::mock(Builder::class);
        $mockRepository = \Mockery::mock(CategoryRepository::class);
        $mockModel = \Mockery::mock(Category::class);
        $mock = \Mockery::mock(CriteriaInterface::class);
        $mock->shouldReceive('apply')
            ->with($mockModel, $mockRepository)
            ->andReturn($mockQueryBuilder);

        $this->assertInstanceOf(Builder::class, $mock->apply($mockModel, $mockRepository));
    }
}