<?php
namespace CodePress\CodeDatabase\Tests\Stub\Criteria;

use CodePress\CodeDatabase\Contracts\CriteriaInterface;
use CodePress\CodeDatabase\Contracts\RepositoryInterface;

class FindByNameAndDescription implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repositery)
    {
        return $model->where('name', 'Category 1')
                    ->where('description', 'Description 1');
    }
}