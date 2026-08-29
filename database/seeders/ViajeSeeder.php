<?php

namespace Database\Seeders;

use App\Enums\EstadoViaje;
use App\Enums\TipoViaje;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Database\Seeder;

class ViajeSeeder extends Seeder
{
    public function run(): void
    {
        $viajero = User::query()->where('email', UserSeeder::VIAJERO_EMAIL)->firstOrFail();

        foreach ($this->viajes() as $viaje) {
            Viaje::query()->create([
                'viajero_id' => $viajero->id,
                'origen' => $viaje['origen'],
                'destino' => $viaje['destino'],
                'tipo' => $viaje['tipo'],
                'fecha_salida' => now()->addDays($viaje['dias'])->toDateString(),
                'notas' => $viaje['notas'],
                'estado' => EstadoViaje::Publicado,
                'imagen_path' => null,
                'imagen_externa_url' => DemoImageUrls::viaje($viaje['origen'], $viaje['destino'], $viaje['tipo']),
            ]);
        }
    }

    private function viajes(): array
    {
        return [
            ['origen' => 'Cartagena', 'destino' => 'San Andrés', 'tipo' => TipoViaje::Playa, 'dias' => 8, 'notas' => 'Semana en islas: snorkel, playa y cayos. Cupo reducido.'],
            ['origen' => 'Medellín', 'destino' => 'Santa Marta', 'tipo' => TipoViaje::Playa, 'dias' => 14, 'notas' => 'Tayrona y playas del Rodadero. Maleta mediana.'],
            ['origen' => 'Bogotá', 'destino' => 'Cancún', 'tipo' => TipoViaje::Playa, 'dias' => 21, 'notas' => 'All inclusive en la Riviera Maya. Espacio para encargos ligeros.'],
            ['origen' => 'Cali', 'destino' => 'Punta Cana', 'tipo' => TipoViaje::Playa, 'dias' => 28, 'notas' => 'Resort de playa. Puedo traer souvenirs y productos de duty free.'],
            ['origen' => 'Barranquilla', 'destino' => 'Riohacha', 'tipo' => TipoViaje::Playa, 'dias' => 11, 'notas' => 'Cabo de la Vela y desierto costero.'],

            ['origen' => 'Bogotá', 'destino' => 'San Gil', 'tipo' => TipoViaje::Aventura, 'dias' => 9, 'notas' => 'Rafting, parapente y rappel. Poco espacio por equipo deportivo.'],
            ['origen' => 'Medellín', 'destino' => 'Villa de Leyva', 'tipo' => TipoViaje::Aventura, 'dias' => 16, 'notas' => 'Senderismo en desierto y fósiles. Puedo cargar 2 kg extra.'],
            ['origen' => 'Cali', 'destino' => 'Salento', 'tipo' => TipoViaje::Aventura, 'dias' => 19, 'notas' => 'Valle del Cocora y trekking en palmas de cera.'],
            ['origen' => 'Bucaramanga', 'destino' => 'Cañón del Chicamocha', 'tipo' => TipoViaje::Aventura, 'dias' => 12, 'notas' => 'Teleférico y deportes extremos.'],

            ['origen' => 'Bogotá', 'destino' => 'Cusco', 'tipo' => TipoViaje::Cultural, 'dias' => 18, 'notas' => 'Machu Picchu y Valle Sagrado. Encargos pequeños de artesanía.'],
            ['origen' => 'Medellín', 'destino' => 'Ciudad de México', 'tipo' => TipoViaje::Cultural, 'dias' => 25, 'notas' => 'Museos, Coyoacán y Teotihuacán.'],
            ['origen' => 'Cali', 'destino' => 'Quito', 'tipo' => TipoViaje::Cultural, 'dias' => 22, 'notas' => 'Centro histórico y Mitad del Mundo.'],
            ['origen' => 'Bogotá', 'destino' => 'Cartagena', 'tipo' => TipoViaje::Cultural, 'dias' => 7, 'notas' => 'Ciudad amurallada, Getsemaní y gastronomía costeña.'],

            ['origen' => 'Bogotá', 'destino' => 'Miami', 'tipo' => TipoViaje::Negocios, 'dias' => 10, 'notas' => 'Feria y reuniones. Maleta de cabina con espacio para 3 encargos.'],
            ['origen' => 'Medellín', 'destino' => 'Panamá', 'tipo' => TipoViaje::Negocios, 'dias' => 13, 'notas' => 'Congreso en Ciudad de Panamá. Duty free disponible.'],
            ['origen' => 'Bogotá', 'destino' => 'São Paulo', 'tipo' => TipoViaje::Negocios, 'dias' => 20, 'notas' => 'Viaje corporativo. Puedo traer electrónicos y muestras.'],
            ['origen' => 'Cali', 'destino' => 'Santiago', 'tipo' => TipoViaje::Negocios, 'dias' => 27, 'notas' => 'Reuniones en Las Condes. Equipaje de bodega.'],

            ['origen' => 'Bogotá', 'destino' => 'Orlando', 'tipo' => TipoViaje::Familiar, 'dias' => 24, 'notas' => 'Parques temáticos con niños. Encargos compactos, no frágiles.'],
            ['origen' => 'Medellín', 'destino' => 'Eje Cafetero', 'tipo' => TipoViaje::Familiar, 'dias' => 15, 'notas' => 'Finca cafetera y parque del café. Familia de 4.'],
            ['origen' => 'Barranquilla', 'destino' => 'San Andrés', 'tipo' => TipoViaje::Familiar, 'dias' => 17, 'notas' => 'Vacaciones escolares. Espacio en maleta grande.'],
            ['origen' => 'Cali', 'destino' => 'Armenia', 'tipo' => TipoViaje::Familiar, 'dias' => 6, 'notas' => 'Fin de semana largo en hacienda.'],

            ['origen' => 'Bogotá', 'destino' => 'París', 'tipo' => TipoViaje::Romantico, 'dias' => 30, 'notas' => 'Luna de miel. Encargos de perfume y moda, máximo 3 unidades.'],
            ['origen' => 'Medellín', 'destino' => 'Cartagena', 'tipo' => TipoViaje::Romantico, 'dias' => 14, 'notas' => 'Aniversario en hotel boutique del centro histórico.'],
            ['origen' => 'Cali', 'destino' => 'Buenos Aires', 'tipo' => TipoViaje::Romantico, 'dias' => 32, 'notas' => 'Tango, Palermo y cenas. Puedo traer vinos y dulces.'],
            ['origen' => 'Bogotá', 'destino' => 'Santorini', 'tipo' => TipoViaje::Romantico, 'dias' => 40, 'notas' => 'Islas griegas. Equipaje limitado; encargos muy livianos.'],

            ['origen' => 'Bogotá', 'destino' => 'Lisboa', 'tipo' => TipoViaje::Mochilero, 'dias' => 35, 'notas' => 'Ruta por Portugal. Mochila de 40 L, 2 kg libres.'],
            ['origen' => 'Medellín', 'destino' => 'Lima', 'tipo' => TipoViaje::Mochilero, 'dias' => 23, 'notas' => 'Hostales y buses. Encargos pequeños y no perecederos.'],
            ['origen' => 'Bogotá', 'destino' => 'Bangkok', 'tipo' => TipoViaje::Mochilero, 'dias' => 45, 'notas' => 'Sudeste asiático por 3 semanas. Encargos de souvenirs livianos.'],
            ['origen' => 'Cali', 'destino' => 'La Paz', 'tipo' => TipoViaje::Mochilero, 'dias' => 26, 'notas' => 'Bolivia: salar y hostales. Poco cupo.'],

            ['origen' => 'Bogotá', 'destino' => 'Leticia', 'tipo' => TipoViaje::Naturaleza, 'dias' => 18, 'notas' => 'Amazonas: selva y río. No llevo encargos líquidos.'],
            ['origen' => 'Medellín', 'destino' => 'Amazonas', 'tipo' => TipoViaje::Naturaleza, 'dias' => 29, 'notas' => 'Observación de fauna. Equipaje técnico.'],
            ['origen' => 'Cali', 'destino' => 'Nuquí', 'tipo' => TipoViaje::Naturaleza, 'dias' => 15, 'notas' => 'Pacífico: ballenas y selva húmeda.'],
            ['origen' => 'Bucaramanga', 'destino' => 'Barichara', 'tipo' => TipoViaje::Naturaleza, 'dias' => 8, 'notas' => 'Pueblos patrimonio y caminos reales.'],

            ['origen' => 'Bogotá', 'destino' => 'Lima', 'tipo' => TipoViaje::Gastronomico, 'dias' => 16, 'notas' => 'Ruta de restaurantes y mercados. Puedo traer café y snacks.'],
            ['origen' => 'Medellín', 'destino' => 'Buenos Aires', 'tipo' => TipoViaje::Gastronomico, 'dias' => 31, 'notas' => 'Parrillas y vinos. Encargos de gastronomía sellada.'],
            ['origen' => 'Cali', 'destino' => 'Ciudad de México', 'tipo' => TipoViaje::Gastronomico, 'dias' => 21, 'notas' => 'Street food y mercados de Coyoacán.'],
            ['origen' => 'Bogotá', 'destino' => 'Madrid', 'tipo' => TipoViaje::Gastronomico, 'dias' => 27, 'notas' => 'Tapas y mercados. Aceite, jamón envasado y dulces.'],

            ['origen' => 'Bogotá', 'destino' => 'Miami', 'tipo' => TipoViaje::Compras, 'dias' => 12, 'notas' => 'Outlet y Sawgrass. Especializado en encargos: hasta 3 unidades por producto.'],
            ['origen' => 'Medellín', 'destino' => 'Nueva York', 'tipo' => TipoViaje::Compras, 'dias' => 22, 'notas' => 'Fifth Avenue y outlets. Electrónicos y ropa.'],
            ['origen' => 'Cali', 'destino' => 'Ciudad de Panamá', 'tipo' => TipoViaje::Compras, 'dias' => 9, 'notas' => 'Multiplaza y duty free del aeropuerto.'],
            ['origen' => 'Barranquilla', 'destino' => 'Orlando', 'tipo' => TipoViaje::Compras, 'dias' => 19, 'notas' => 'Mall Premium Outlets. Ropa y cosméticos.'],

            ['origen' => 'Bogotá', 'destino' => 'Boston', 'tipo' => TipoViaje::Estudio, 'dias' => 50, 'notas' => 'Curso corto en universidad. Encargos de útiles y libros.'],
            ['origen' => 'Medellín', 'destino' => 'Barcelona', 'tipo' => TipoViaje::Estudio, 'dias' => 55, 'notas' => 'Intercambio de un mes. Puedo traer material académico.'],
            ['origen' => 'Cali', 'destino' => 'Buenos Aires', 'tipo' => TipoViaje::Estudio, 'dias' => 40, 'notas' => 'Curso de español y diseño.'],

            ['origen' => 'Cartagena', 'destino' => 'Cozumel', 'tipo' => TipoViaje::Crucero, 'dias' => 20, 'notas' => 'Crucero por el Caribe. Encargos solo al desembarcar.'],
            ['origen' => 'Cartagena', 'destino' => 'Aruba', 'tipo' => TipoViaje::Crucero, 'dias' => 18, 'notas' => 'Itinerario islas ABC. Maleta de bodega.'],
            ['origen' => 'Miami', 'destino' => 'Nassau', 'tipo' => TipoViaje::Crucero, 'dias' => 15, 'notas' => 'Bahamas en crucero de 7 noches.'],

            ['origen' => 'Bogotá', 'destino' => 'Nueva York', 'tipo' => TipoViaje::Urbano, 'dias' => 17, 'notas' => 'City break: museos, Broadway y barrios.'],
            ['origen' => 'Medellín', 'destino' => 'Madrid', 'tipo' => TipoViaje::Urbano, 'dias' => 23, 'notas' => 'Capitales europeas empezando por Madrid.'],
            ['origen' => 'Bogotá', 'destino' => 'Tokio', 'tipo' => TipoViaje::Urbano, 'dias' => 42, 'notas' => 'Shibuya, templos y tecnología. Encargos de gadgets.'],
            ['origen' => 'Cali', 'destino' => 'São Paulo', 'tipo' => TipoViaje::Urbano, 'dias' => 14, 'notas' => 'Vida urbana, cafés y centros comerciales.'],

            ['origen' => 'Bogotá', 'destino' => 'Bariloche', 'tipo' => TipoViaje::Nieve, 'dias' => 33, 'notas' => 'Ski en la Patagonia. Equipo de nieve ocupa espacio.'],
            ['origen' => 'Medellín', 'destino' => 'Aspen', 'tipo' => TipoViaje::Nieve, 'dias' => 38, 'notas' => 'Temporada de ski. Encargos muy livianos.'],
            ['origen' => 'Bogotá', 'destino' => 'Chachapoyas', 'tipo' => TipoViaje::Nieve, 'dias' => 25, 'notas' => 'Alta montaña andina y lagunas. Clima frío.'],

            ['origen' => 'Bogotá', 'destino' => 'Guatapé', 'tipo' => TipoViaje::Bienestar, 'dias' => 5, 'notas' => 'Retiro de fin de semana en hotel con spa.'],
            ['origen' => 'Medellín', 'destino' => 'Santa Fe de Antioquia', 'tipo' => TipoViaje::Bienestar, 'dias' => 7, 'notas' => 'Termales y descanso. Encargos de cosmétiica.'],
            ['origen' => 'Cali', 'destino' => 'Melgar', 'tipo' => TipoViaje::Bienestar, 'dias' => 6, 'notas' => 'Piscina y descanso familiar corto.'],
            ['origen' => 'Bogotá', 'destino' => 'Tulum', 'tipo' => TipoViaje::Bienestar, 'dias' => 28, 'notas' => 'Yoga y wellness en la costa maya.'],
        ];
    }
}
