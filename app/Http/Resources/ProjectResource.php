<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    public static $wrap = false;

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
            'status' => $this->status,
            'image_path' => $this->image_path ? Storage::url($this->image_path) : '',
            'due_date' => (new Carbon($this->due_date))->format('Y-m-d'),
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy
        ];
    }
}
