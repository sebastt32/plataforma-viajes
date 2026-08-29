<?php

namespace App\Services;

use App\Enums\EstadoViaje;
use App\Models\Producto;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ViajeProductoService
{
    public function listarViajes(User $viajero): Collection
    {
        return $viajero->viajes()
            ->withCount('productos')
            ->latest('fecha_salida')
            ->get();
    }

    public function crearViaje(User $viajero, array $datos, ?UploadedFile $imagen = null): Viaje
    {
        $imagenDatos = $this->resolverImagenDatos($imagen, $datos['imagen_externa_url'] ?? null, null, null, 'viajes');

        return $viajero->viajes()->create([
            'origen' => $datos['origen'],
            'destino' => $datos['destino'],
            'tipo' => $datos['tipo'],
            'fecha_salida' => $datos['fecha_salida'],
            'notas' => $datos['notas'] ?? null,
            'estado' => EstadoViaje::Publicado,
            ...$imagenDatos,
        ]);
    }

    public function actualizarViaje(Viaje $viaje, array $datos, ?UploadedFile $imagen = null): Viaje
    {
        $imagenDatos = $this->resolverImagenDatos(
            $imagen,
            array_key_exists('imagen_externa_url', $datos) ? $datos['imagen_externa_url'] : $viaje->imagen_externa_url,
            $viaje->imagen_path,
            $viaje->imagen_externa_url,
            'viajes',
            array_key_exists('imagen_externa_url', $datos),
        );

        $viaje->update([
            'origen' => $datos['origen'],
            'destino' => $datos['destino'],
            'tipo' => $datos['tipo'],
            'fecha_salida' => $datos['fecha_salida'],
            'notas' => $datos['notas'] ?? null,
            'estado' => $datos['estado'] ?? $viaje->estado,
            ...$imagenDatos,
        ]);

        return $viaje->refresh();
    }

    public function eliminarViaje(Viaje $viaje): void
    {
        if ($viaje->productos()->whereHas('solicitudes')->exists()) {
            throw ValidationException::withMessages([
                'viaje' => 'No se puede eliminar un viaje con solicitudes de compra.',
            ]);
        }

        $this->eliminarImagen($viaje->imagen_path);
        $viaje->delete();
    }

    public function listarProductos(User $viajero): Collection
    {
        return $viajero->productos()
            ->with('viaje')
            ->latest()
            ->get();
    }

    public function crearProducto(User $viajero, array $datos, ?UploadedFile $imagen = null): Producto
    {
        $this->asegurarCantidadMaxima($datos['cantidad_max']);
        $this->asegurarViajeDelViajero($viajero, (int) $datos['viaje_id']);

        $imagenDatos = $this->resolverImagenDatos($imagen, $datos['imagen_externa_url'] ?? null, null, null, 'productos');

        $producto = $viajero->productos()->create([
            'viaje_id' => $datos['viaje_id'],
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'precio' => $datos['precio'],
            'fee_transporte' => $datos['fee_transporte'],
            'cantidad_max' => $datos['cantidad_max'],
            'cantidad_disponible' => $datos['cantidad_max'],
            ...$imagenDatos,
        ]);

        return $producto;
    }

    public function actualizarProducto(Producto $producto, array $datos, ?UploadedFile $imagen = null): Producto
    {
        $this->asegurarCantidadMaxima($datos['cantidad_max']);
        $this->asegurarViajeDelViajero($producto->viajero, (int) $datos['viaje_id']);

        $reservado = $producto->cantidad_max - $producto->cantidad_disponible;
        $nuevaMax = (int) $datos['cantidad_max'];

        if ($nuevaMax < $reservado) {
            throw ValidationException::withMessages([
                'cantidad_max' => 'No puedes bajar el límite por debajo de las unidades ya solicitadas.',
            ]);
        }

        $imagenDatos = $this->resolverImagenDatos(
            $imagen,
            array_key_exists('imagen_externa_url', $datos) ? $datos['imagen_externa_url'] : $producto->imagen_externa_url,
            $producto->imagen_path,
            $producto->imagen_externa_url,
            'productos',
            array_key_exists('imagen_externa_url', $datos),
        );

        $producto->update([
            'viaje_id' => $datos['viaje_id'],
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'precio' => $datos['precio'],
            'fee_transporte' => $datos['fee_transporte'],
            'cantidad_max' => $nuevaMax,
            'cantidad_disponible' => $nuevaMax - $reservado,
            ...$imagenDatos,
        ]);

        return $producto->refresh();
    }

    public function eliminarProducto(Producto $producto): void
    {
        if ($producto->solicitudes()->exists()) {
            throw ValidationException::withMessages([
                'producto' => 'No se puede eliminar un producto con solicitudes.',
            ]);
        }

        $this->eliminarImagen($producto->imagen_path);
        $producto->delete();
    }

    public function catalogo(?string $busqueda = null, ?string $tipo = null): Collection
    {
        return Viaje::query()
            ->with(['viajero'])
            ->withCount('productos')
            ->where('estado', EstadoViaje::Publicado)
            ->when($tipo, fn ($query) => $query->where('tipo', $tipo))
            ->when($busqueda, function ($query, string $busqueda) {
                $query->where(function ($query) use ($busqueda) {
                    $query->where('origen', 'like', '%'.$busqueda.'%')
                        ->orWhere('destino', 'like', '%'.$busqueda.'%')
                        ->orWhere('notas', 'like', '%'.$busqueda.'%');
                });
            })
            ->orderBy('fecha_salida')
            ->get();
    }

    private function asegurarCantidadMaxima(int $cantidad): void
    {
        if ($cantidad < 1 || $cantidad > Producto::CANTIDAD_MAXIMA_PERMITIDA) {
            throw ValidationException::withMessages([
                'cantidad_max' => 'Cada producto admite como máximo '.Producto::CANTIDAD_MAXIMA_PERMITIDA.' unidades.',
            ]);
        }
    }

    private function asegurarViajeDelViajero(User $viajero, int $viajeId): void
    {
        $existe = $viajero->viajes()->whereKey($viajeId)->exists();

        if (! $existe) {
            throw ValidationException::withMessages([
                'viaje_id' => 'Debes elegir un viaje propio.',
            ]);
        }
    }

    private function resolverImagenDatos(
        ?UploadedFile $imagen,
        ?string $urlExterna,
        ?string $pathActual,
        ?string $urlExternaActual,
        string $carpeta,
        bool $urlEnviada = true,
    ): array {
        if ($imagen) {
            $this->eliminarImagen($pathActual);

            return [
                'imagen_path' => $this->guardarImagen($imagen, $carpeta),
                'imagen_externa_url' => null,
            ];
        }

        if ($urlEnviada) {
            $urlExterna = blank($urlExterna) ? null : $urlExterna;

            if ($urlExterna) {
                $this->eliminarImagen($pathActual);

                return [
                    'imagen_path' => null,
                    'imagen_externa_url' => $urlExterna,
                ];
            }

            if ($pathActual) {
                return [
                    'imagen_path' => $pathActual,
                    'imagen_externa_url' => null,
                ];
            }

            return [
                'imagen_path' => null,
                'imagen_externa_url' => null,
            ];
        }

        return [
            'imagen_path' => $pathActual,
            'imagen_externa_url' => $urlExternaActual,
        ];
    }

    private function guardarImagen(UploadedFile $imagen, string $carpeta): string
    {
        return $imagen->store($carpeta, config('filesystems.default'));
    }

    private function eliminarImagen(?string $path): void
    {
        if ($path) {
            Storage::disk(config('filesystems.default'))->delete($path);
        }
    }
}
