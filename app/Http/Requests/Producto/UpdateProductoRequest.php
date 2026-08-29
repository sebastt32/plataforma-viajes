<?php

namespace App\Http\Requests\Producto;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('producto')) ?? false;
    }

    public function rules(): array
    {
        return [
            'viaje_id' => [
                'required',
                Rule::exists('viajes', 'id')->where('viajero_id', $this->user()->id),
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'fee_transporte' => ['required', 'numeric', 'min:0'],
            'cantidad_max' => ['required', 'integer', 'min:1', 'max:'.Producto::CANTIDAD_MAXIMA_PERMITIDA],
            'imagen' => ['nullable', 'image', 'max:4096', 'prohibited_if:imagen_externa_url,*'],
            'imagen_externa_url' => ['nullable', 'url', 'max:2048', 'prohibited_if:imagen,*'],
        ];
    }

    public function messages(): array
    {
        return [
            'cantidad_max.max' => 'Cada producto admite como máximo '.Producto::CANTIDAD_MAXIMA_PERMITIDA.' unidades.',
        ];
    }
}
