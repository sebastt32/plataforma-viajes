@php
    $viaje = $viaje ?? [];
@endphp

<div class="space-y-5">
    <div>
        <x-input-label for="origen" value="Origen" />
        <x-text-input id="origen" name="origen" class="mt-1 block w-full" :value="old('origen', $viaje['origen'] ?? '')" required />
        <x-input-error :messages="$errors->get('origen')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="destino" value="Destino" />
        <x-text-input id="destino" name="destino" class="mt-1 block w-full" :value="old('destino', $viaje['destino'] ?? '')" required />
        <x-input-error :messages="$errors->get('destino')" class="mt-2" />
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <x-input-label for="tipo" value="Tipo de viaje" />
            <x-select-input id="tipo" name="tipo" class="mt-1 block w-full" required>
                <option value="">Selecciona un tipo</option>
                @foreach ($tipos as $opcion)
                    <option value="{{ $opcion->value }}" @selected(old('tipo', $viaje['tipo'] ?? '') === $opcion->value)>{{ $opcion->etiqueta() }}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="fecha_salida" value="Fecha de salida" />
            <x-text-input id="fecha_salida" type="date" name="fecha_salida" class="mt-1 block w-full" :value="old('fecha_salida', $viaje['fecha_salida'] ?? '')" required />
            <x-input-error :messages="$errors->get('fecha_salida')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="notas" value="Notas" />
        <x-textarea-input id="notas" name="notas" rows="3" class="mt-1 block w-full">{{ old('notas', $viaje['notas'] ?? '') }}</x-textarea-input>
        <x-input-error :messages="$errors->get('notas')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="imagen" value="Foto del viaje (archivo)" />
        <x-file-input name="imagen" />
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="imagen_externa_url" value="O enlace de imagen (URL pública)" />
        <x-text-input id="imagen_externa_url" name="imagen_externa_url" type="url" class="mt-1 block w-full" :value="old('imagen_externa_url', $viaje['imagen_externa_url'] ?? '')" placeholder="https://..." />
        <p class="mt-1 text-xs text-muted">Usa archivo o URL, no ambos.</p>
        <x-input-error :messages="$errors->get('imagen_externa_url')" class="mt-2" />
        @if (! empty($viaje['imagen_url']))
            <img src="{{ $viaje['imagen_url'] }}" alt="" class="mt-3 h-24 rounded-lg object-cover">
        @endif
    </div>

    @isset($estados)
        <div>
            <x-input-label for="estado" value="Estado" />
            <x-select-input id="estado" name="estado" class="mt-1 block w-full">
                @foreach ($estados as $estado)
                    <option value="{{ $estado->value }}" @selected(old('estado', $viaje['estado'] ?? '') === $estado->value)>{{ $estado->etiqueta() }}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
        </div>
    @endisset
</div>
