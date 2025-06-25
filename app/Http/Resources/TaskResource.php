<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'status' => $this->status,
        'due_date' => $this->due_date,
        'assigned_to' => $this->whenLoaded('assignedTo', function () {
            return $this->assignedTo
                ? ['id' => $this->assignedTo->id, 'name' => $this->assignedTo->name]
                : null;
        }),
    ];
}

}

