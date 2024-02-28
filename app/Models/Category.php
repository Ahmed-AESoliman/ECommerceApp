<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_name',
        'parent_category',
    ];

    public function subCategory()
    {
        return $this->hasMany(self::class, 'parent_category');
    }
    public function category()
    {
        return $this->belongsTo(self::class, 'parent_category');
    }

    public function productBysubCategory()
    {
        return $this->hasMany(Product::class, 'sub_category');
    }
    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeFilter($query, $request): mixed
    {
        if ($request->filled('name')) {
            $query->where('category_name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('category')) {
            $query->where('parent_category', $request->input('category'));
        }
        if ($request->filled('sort_by')) {
            $sortColumn = $request->input('sort_by');
            $sortType = $request->input('sort_type', 'asc');
            $query->orderBy($sortColumn, $sortType);
        }
        return $query;
    }
}