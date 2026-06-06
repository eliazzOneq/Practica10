<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|min:3|max:100',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0.01|max:99999',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpg,png,webp,jpeg|max:2048',
        ];
    }

    public function messages(): array
    {
        return (new StoreProductoRequest())->messages();
    }
}