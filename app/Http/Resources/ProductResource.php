<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'unit_discount' => $this->unit_discount,
            'available_size' => $this->available_size,
            'available_colors' => $this->available_colors,
            'unit_in_stock' => $this->unit_in_stock,
            'unit_weight' => $this->unit_weight,
            'unit_on_order' => $this->unit_on_order,
            'category' => $this->mainCategory?->category_name,
            'sub_category' => $this->subCategory?->category_name,
        ];
    }
}
