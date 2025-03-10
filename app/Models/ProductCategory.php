<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // Relationship to parent category
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Relationship to subcategories
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Relationship to products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
