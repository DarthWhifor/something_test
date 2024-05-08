<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'parent_parent_id',
        'title',
    ];
    /**
     * @var mixed
     */
    private $id;
    private $parent;

    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        $parent = ProductCategory::where('id', $this->parent_id)->first();
        return $parent != null ? $parent->title : '';
    }

    public function getParentParent()
    {
        $parentParent = ProductCategory::where('id', $this->parent_parent_id)->first();
        return $parentParent != null ? $parentParent->title : '';
    }

    public function getParentParentId()
    {
        $parentParent = ProductCategory::where('id', $this->parent_parent_id)->first();
        return $parentParent != null ? $parentParent->attributes['id'] : '';
    }

    public function getParentId()
    {
        $parent = ProductCategory::where('id', $this->parent_id)->first();
        return $parent != null ? $parent->attributes['id'] : '';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
