<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\Redis;

class Category extends Model
{
    use NodeTrait;

    protected $fillable = ['name','position', 'status', 'parent_id'];

    public function create(array $attributes = [], self $parent = null)
    {
        parent::create($attributes, $parent);
        Redis::del('category:home:tree');
    }

    /**
     * 需要移到repository层，暂时先简单处理
     */
    public function getCategoryTree($id = null)
    {
        return $id
            ? Category::orderBy('position', 'ASC')->where('id', '!=', $id)->get()->toTree()
            : Category::orderBy('position', 'ASC')->get()->toTree();
    }
}
