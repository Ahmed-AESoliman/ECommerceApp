<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'unit_discount',
        'available_size',
        'available_colors',
        'unit_in_stock',
        'unit_weight',
        'unit_on_order',
        'category',
        'sub_category',
    ];

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeFilter($query, $request): mixed
    {
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }
        if ($request->filled('sub_category')) {
            $query->where('sub_category', $request->input('sub_category'));
        }
        if ($request->filled('sort_by')) {
            $sortColumn = $request->input('sort_by');
            $sortType = $request->input('sort_type', 'asc');
            $query->orderBy($sortColumn, $sortType);
        }
        return $query;
    }
}
