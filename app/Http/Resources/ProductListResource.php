<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'description' => substr($this->description, 0, 20) . '...',
            'unit_price' => $this->unit_price,
            'unit_discount' => $this->unit_discount,
            'category' => $this->mainCategory?->category_name,
            'sub_category' => $this->subCategory?->category_name,
            'sub_category' => $this->subCategory?->category_name,
            'attachments' => $this->attachments?->pluck('file_path')->first()
        ];
    }
}
