<?php

namespace App\Http\Requests\Viaje;

use App\Enums\EstadoViaje;
use App\Enums\TipoViaje;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreViajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esViajero() ?? false;
    }

    public function rules(): array
    {
        return [
            'origen' => ['required', 'string', 'max:255'],
            'destino' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::enum(TipoViaje::class)],
            'fecha_salida' => ['required', 'date', 'after_or_equal:today'],
            'notas' => ['nullable', 'string', 'max:1000'],
            'imagen' => ['nullable', 'image', 'max:4096', 'prohibited_if:imagen_externa_url,*'],
            'imagen_externa_url' => ['nullable', 'url', 'max:2048', 'prohibited_if:imagen,*'],
            'estado' => ['sometimes', Rule::enum(EstadoViaje::class)],
        ];
    }
}
