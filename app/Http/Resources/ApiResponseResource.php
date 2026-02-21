<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'success' => $this['success'] ?? true,
            'code' => $this['code'] ?? 200,
            'message' => $this['message'] ?? null,
            'data' => $this['data'] ?? null,
            'errors' => $this['errors'] ?? null,
        ];
    }


    public function withResponse($request, $response)
    {
        $response->setStatusCode($this['code'] ?? 200);
    }
}
