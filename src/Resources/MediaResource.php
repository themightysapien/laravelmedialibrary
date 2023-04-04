<?php
namespace Themightysapien\MediaLibrary\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "model_type" => $this->model_type,
            "model_id" => $this->model_id,
            "uuid" => $this->uuid,
            "collection_name" => $this->collection_name,
            "name" => $this->file,
            "file_name" => $this->file_name,
            "mime_type" => $this->mime_type,
            "disk" => $this->disk,
            "conversions_disk" => $this->conversion_disk,
            "size" => $this->size,
            "manipulations" => $this->manipulations,
            "custom_properties" => $this->custom_properties,
            "generated_conversions" => $this->generated_conversions,
            "responsive_images" => $this->responsive_images,
            "order_column" => $this->order_column,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
