<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        $parent = ProductCategory::where('id', $this->category_id)->first();
        return $parent != null ? $parent->title : '';
    }

    public function getParentId()
    {
        $parent = ProductCategory::where('id', $this->category_id)->first();
        return $parent != null ? $parent->id : '';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function getMainPhoto()
    {
        $photo = Photo::where('main', Photo::PHOTO_MAIN)->where('product_id', $this->getId())->first();
        return $photo->path ?? null;
    }


}
