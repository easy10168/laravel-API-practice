<?php

namespace App\Http\Resources;

use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'publish_date' => $this->publish_date,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'subcategory' => new SubcategoryResource($this->subcategory)
        ];
    }
}
