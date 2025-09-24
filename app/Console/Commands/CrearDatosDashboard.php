<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\MedioPago;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CrearDatosDashboard extends Command
{
    protected $signature = 'dashboard:crear-datos';
    protected $description = 'Crear datos de ejemplo para el dashboard del administrador';

    public function handle()
    {
        $this->info('Creando datos de ejemplo para el dashboard...');

        // Crear usuarios de ejemplo si no existen
        $this->crearUsuarios();
        
        // Crear productos de ejemplo si no existen
        $this->crearProductos();
        
        // Crear medios de pago
        $this->crearMediosPago();
        
        // Crear compras (pedidos)
        $this->crearCompras();
        
        // Crear ventas
        $this->crearVentas();
        
        // Crear pagos
        $this->crearPagos();

        $this->info('Datos de ejemplo creados exitosamente!');
        $this->info('- Usuarios: ' . User::count());
        $this->info('- Productos: ' . Producto::count());
        $this->info('- Compras: ' . Compra::count());
        $this->info('- Ventas: ' . Venta::count());
        $this->info('- Pagos: ' . Pago::count());
    }

    private function crearUsuarios()
    {
        $usuarios = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'first_name' => 'Juan',
                'last_name' => 'Pérez',
                'document_type' => 'CC',
                'document_number' => '1001234567',
                'phone' => '3001234567',
                'address' => 'Calle 123 #45-67, Bogotá',
                'password' => Hash::make('password'),
                'role' => 'cliente'
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@example.com',
                'first_name' => 'María',
                'last_name' => 'García',
                'document_type' => 'CC',
                'document_number' => '1008765432',
                'phone' => '3007654321',
                'address' => 'Carrera 45 #78-90, Medellín',
                'password' => Hash::make('password'),
                'role' => 'cliente'
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos.lopez@example.com',
                'first_name' => 'Carlos',
                'last_name' => 'López',
                'document_type' => 'CC',
                'document_number' => '1001122334',
                'phone' => '3001122334',
                'address' => 'Avenida 80 #12-34, Cali',
                'password' => Hash::make('password'),
                'role' => 'cliente'
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::firstOrCreate(
                ['email' => $usuario['email']],
                $usuario
            );
        }
    }

    private function crearProductos()
    {
        $productos = [
            [
                'Codigo' => 'LAP001',
                'Nombre' => 'Laptop Gaming ASUS',
                'Stock' => 15,
                'Proveedor' => 'ASUS Colombia'
            ],
            [
                'Codigo' => 'CEL001',
                'Nombre' => 'Smartphone Samsung Galaxy',
                'Stock' => 25,
                'Proveedor' => 'Samsung Colombia'
            ],
            [
                'Codigo' => 'AUD001',
                'Nombre' => 'Auriculares Bluetooth Sony',
                'Stock' => 40,
                'Proveedor' => 'Sony Colombia'
            ],
            [
                'Codigo' => 'TAB001',
                'Nombre' => 'Tablet iPad Air',
                'Stock' => 12,
                'Proveedor' => 'Apple Colombia'
            ],
            [
                'Codigo' => 'REL001',
                'Nombre' => 'Smartwatch Apple Watch',
                'Stock' => 20,
                'Proveedor' => 'Apple Colombia'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(
                ['Codigo' => $producto['Codigo']],
                $producto
            );
        }
    }

    private function crearMediosPago()
    {
        $medios = [
            ['Metodo_pago' => 'Tarjeta de Crédito', 'ID_Pagos' => 1],
            ['Metodo_pago' => 'Tarjeta Débito', 'ID_Pagos' => 2],
            ['Metodo_pago' => 'Transferencia Bancaria', 'ID_Pagos' => 3],
            ['Metodo_pago' => 'Efectivo', 'ID_Pagos' => 4],
            ['Metodo_pago' => 'PSE', 'ID_Pagos' => 5]
        ];

        foreach ($medios as $medio) {
            MedioPago::firstOrCreate(
                ['Metodo_pago' => $medio['Metodo_pago']],
                $medio
            );
        }
    }

    private function crearCompras()
    {
        $clientes = User::where('role', 'cliente')->get();
        $productos = Producto::all();
        $mediosPago = MedioPago::all();
        $estados = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];

        for ($i = 0; $i < 20; $i++) {
            $cliente = $clientes->random();
            $medioPago = $mediosPago->random();
            $estado = $estados[array_rand($estados)];
            $fecha = Carbon::now()->subDays(rand(0, 30));

            $compra = Compra::create([
                'ID_Usuario' => $cliente->id,
                'ID_MedioDePago' => $medioPago->ID_MedioDePago,
                'Fecha_De_Compra' => $fecha,
                'Fecha_Compra' => $fecha,
                'Tiempo_De_Entrega' => rand(1, 7),
                'Total' => 0, // Se calculará con los detalles
                'Estado' => $estado
            ]);

            // Crear detalles de compra
            $numProductos = rand(1, 3);
            $total = 0;

            for ($j = 0; $j < $numProductos; $j++) {
                $producto = $productos->random();
                $cantidad = rand(1, 2);
                $precio = rand(100000, 2000000); // Precio aleatorio
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                DetalleCompra::create([
                    'ID_Compras' => $compra->ID_Compras,
                    'ID_Producto' => $producto->ID_Producto,
                    'Cantidad' => $cantidad,
                    'Precio' => $precio
                ]);
            }

            $compra->update(['Total' => $total]);
        }
    }

    private function crearVentas()
    {
        $clientes = User::where('role', 'cliente')->get();
        $productos = Producto::all();

        for ($i = 0; $i < 15; $i++) {
            $cliente = $clientes->random();
            $fecha = Carbon::now()->subDays(rand(0, 30));

            $venta = Venta::create([
                'ID_Usuario' => $cliente->id,
                'fecha_venta' => $fecha
            ]);

            // Crear detalles de venta
            $numProductos = rand(1, 2);
            for ($j = 0; $j < $numProductos; $j++) {
                $producto = $productos->random();
                $cantidad = rand(1, 2);

                DetalleVenta::create([
                    'ID_Ventas' => $venta->ID_Ventas,
                    'ID_Producto' => $producto->ID_Producto,
                    'Cantidad' => $cantidad,
                    'Precio' => rand(100000, 1500000) // Precio aleatorio para las ventas
                ]);
            }
        }
    }

    private function crearPagos()
    {
        $compras = Compra::all();
        $estados = ['pendiente', 'aprobado', 'rechazado', 'cancelado'];

        foreach ($compras as $compra) {
            $estado = $estados[array_rand($estados)];
            $fechaPago = $compra->Fecha_De_Compra->addDays(rand(0, 2));

            Pago::create([
                'Fecha_Pago' => $fechaPago,
                'Numero_Factura' => $compra->ID_Compras,
                'Fecha_Factura' => $compra->Fecha_De_Compra,
                'Monto' => $compra->Total,
                'Estado_Pago' => $estado
            ]);
        }
    }
}
