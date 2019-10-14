<?php
namespace CodePress\CodeDatabase\Tests\CodeDatabase;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeDatabase\Contracts\RepositoryInterface;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use CodePress\CodeDatabase\Tests\Stub\Model\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AbstractRepositoryTest extends AbstractTestCase
{
    /*public function setUp()
    {
        parent::setUp();
        $this->migrate();
        Category::create(['name' => 'name', 'description' => 'description']);
    }*/

    public function test_if_implements_repositoryinterface()
    {
        $mock = \Mockery::mock(AbstractRepository::class);
        $this->assertInstanceOf(RepositoryInterface::class, $mock);
    }

    public function test_should_return_all_without_argument()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';
        $mockStd->description = 'Description';

        $mockRepository->shouldReceive('all')
            ->andReturn([$mockStd, $mockStd, $mockStd]);
        $result = $mockRepository->all();
        $this->assertCount(3, $result);
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_all_with_argument()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('all')
            ->with(['id', 'name'])
            ->andReturn([$mockStd, $mockStd, $mockStd]);

        $result = $mockRepository->all(['id', 'name']);

        $this->assertCount(3,$result );
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_create()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('create')
            ->with(['name' => 'strClassName'])
            ->andReturn($mockStd);

        $result = $mockRepository->create(['name' => 'strClassName']);

        $this->assertEquals(1, $result->id);

        $this->assertInstanceOf(
            \stdClass::class,
            $result
        );
    }

    public function test_should_return_update_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('update')
            ->with(['name' => 'strClassName'], 1)
            ->andReturn($mockStd);

        $result = $mockRepository->update(['name' => 'strClassName'], 1);

        $this->assertEquals(1, $result->id);

        $this->assertInstanceOf(
            \stdClass::class,
            $result
        );
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_update_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('update')
            ->with(['name' => 'strClassName'], 0)
            ->andThrow($throw);

        $mockRepository->update(['name' => 'strClassName'], 0);
    }

    public function test_should_return_delete_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $mockRepository->shouldReceive('delete')
            ->with(1)
            ->andReturn(true);

        $result = $mockRepository->delete(1);

        $this->assertEquals(true, $result);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_delete_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('delete')
            ->with(0)
            ->andThrow($throw);

        $mockRepository->delete(0);
    }

    public function test_should_return_find_without_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';
        $mockStd->description = 'Description';

        $mockRepository->shouldReceive('find')
            ->with(1)
            ->andReturn($mockStd);

        $result = $mockRepository->find(1);

        $this->assertInstanceOf(\stdClass::class,  $result);
    }

    public function test_should_return_find_with_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('find')
            ->with(1, ['id', 'name'])
            ->andReturn($mockStd);

        $result = $mockRepository->find(1, ['id', 'name']);

        $this->assertInstanceOf(\stdClass::class,  $result);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_find_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('find')
            ->with(0)
            ->andThrow($throw);

        $mockRepository->find(0);
    }

    public function test_should_return_findby_with_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('findBy')
            ->with('name', 'my-data', ['id', 'name'])
            ->andReturn([$mockStd, $mockStd, $mockStd]);

        $result = $mockRepository->findBy('name', 'my-data', ['id', 'name']);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_findby_empty_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->name = 'Name';

        $mockRepository->shouldReceive('findBy')
            ->with('name', '', ['id', 'name'])
            ->andReturn([]);

        $result = $mockRepository->findBy('name', '', ['id', 'name']);

        $this->assertCount(0, $result);
    }
}