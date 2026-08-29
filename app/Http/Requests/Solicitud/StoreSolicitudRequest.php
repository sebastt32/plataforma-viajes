<?php

namespace App\Http\Requests\Solicitud;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esComprador() ?? false;
    }

    public function rules(): array
    {
        $disponible = $this->route('producto')?->cantidad_disponible ?? 1;

        return [
            'cantidad' => ['required', 'integer', 'min:1', 'max:'.min($disponible, Producto::CANTIDAD_MAXIMA_PERMITIDA)],
        ];
    }
}
