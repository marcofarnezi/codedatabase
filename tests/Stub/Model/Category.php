<?php
namespace CodePress\CodeDatabase\Tests\Stub\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = "codepress_category";

    protected $fillable = [
        'name',
        'description',
    ];
}