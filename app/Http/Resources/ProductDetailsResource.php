<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [

            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'unit_discount' => $this->unit_discount,
            'available_size' => json_decode($this->available_size),
            'available_colors' => json_decode($this->available_colors),
            'unit_weight' => $this->unit_weight,
            'category' => $this->mainCategory?->category_name,
            'sub_category' => $this->subCategory?->category_name,
            'sub_category' => $this->subCategory?->category_name,
            'attachments' => $this->attachments?->pluck('file_path')
        ];
    }
}
