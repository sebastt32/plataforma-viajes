@php
    $producto = $producto ?? [];
@endphp

<div class="space-y-5">
    <div>
        <x-input-label for="viaje_id" value="Viaje" />
        <x-select-input id="viaje_id" name="viaje_id" class="mt-1 block w-full" required>
            @foreach ($viajes as $viaje)
                <option value="{{ $viaje['id'] }}" @selected((string) old('viaje_id', $producto['viaje']['id'] ?? '') === (string) $viaje['id'])>
                    {{ $viaje['origen'] }} → {{ $viaje['destino'] }} ({{ $viaje['fecha_salida'] }})
                </option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('viaje_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="nombre" value="Nombre" />
        <x-text-input id="nombre" name="nombre" class="mt-1 block w-full" :value="old('nombre', $producto['nombre'] ?? '')" required />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <x-textarea-input id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full">{{ old('descripcion', $producto['descripcion'] ?? '') }}</x-textarea-input>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <x-input-label for="precio" value="Precio" />
            <x-text-input id="precio" type="number" step="0.01" min="0.01" name="precio" class="mt-1 block w-full" :value="old('precio', $producto['precio'] ?? '')" required />
            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="fee_transporte" value="Fee de transporte" />
            <x-text-input id="fee_transporte" type="number" step="0.01" min="0" name="fee_transporte" class="mt-1 block w-full" :value="old('fee_transporte', $producto['fee_transporte'] ?? '')" required />
            <x-input-error :messages="$errors->get('fee_transporte')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="cantidad_max" value="Cantidad máxima (1 a 3)" />
        <x-text-input id="cantidad_max" type="number" min="1" max="3" name="cantidad_max" class="mt-1 block w-24" :value="old('cantidad_max', $producto['cantidad_max'] ?? 1)" required />
        <x-input-error :messages="$errors->get('cantidad_max')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="imagen" value="Imagen (archivo)" />
        <x-file-input name="imagen" />
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="imagen_externa_url" value="O enlace de imagen (URL pública)" />
        <x-text-input id="imagen_externa_url" name="imagen_externa_url" type="url" class="mt-1 block w-full" :value="old('imagen_externa_url', $producto['imagen_externa_url'] ?? '')" placeholder="https://..." />
        <p class="mt-1 text-xs text-muted">Usa archivo o URL, no ambos.</p>
        <x-input-error :messages="$errors->get('imagen_externa_url')" class="mt-2" />
        @if (! empty($producto['imagen_url']))
            <img src="{{ $producto['imagen_url'] }}" alt="" class="mt-3 h-24 rounded-lg object-cover">
        @endif
    </div>
</div>
