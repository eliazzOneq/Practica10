<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'imagen' => $this->imagen,
            'imagen_url' => $this->imagen
                ? asset('storage/' . $this->imagen)
                : null,
            'categoria_id' => $this->categoria_id,
            'categoria_nombre' => $this->categoria?->nombre,
        ];
    }
}