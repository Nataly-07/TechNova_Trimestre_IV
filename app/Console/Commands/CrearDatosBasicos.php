<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\Producto;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CrearDatosBasicos extends Command
{
    protected $signature = 'dashboard:datos-basicos';
    protected $description = 'Crear datos básicos para el dashboard';

    public function handle()
    {
        $this->info('Creando datos básicos para el dashboard...');

        // Crear algunos usuarios de ejemplo
        $this->crearUsuariosBasicos();
        
        // Crear algunos productos básicos
        $this->crearProductosBasicos();
        
        // Crear algunas compras básicas
        $this->crearComprasBasicas();
        
        // Crear algunas ventas básicas
        $this->crearVentasBasicas();
        
        // Crear algunos pagos básicos
        $this->crearPagosBasicos();

        $this->info('Datos básicos creados exitosamente!');
    }

    private function crearUsuariosBasicos()
    {
        $usuarios = [
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@example.com',
                'first_name' => 'Ana',
                'last_name' => 'Martínez',
                'document_type' => 'CC',
                'document_number' => '2001234567',
                'phone' => '3001234567',
                'address' => 'Calle 100 #50-25, Bogotá',
                'password' => Hash::make('password'),
                'role' => 'cliente'
            ],
            [
                'name' => 'Luis Rodríguez',
                'email' => 'luis.rodriguez@example.com',
                'first_name' => 'Luis',
                'last_name' => 'Rodríguez',
                'document_type' => 'CC',
                'document_number' => '2008765432',
                'phone' => '3007654321',
                'address' => 'Carrera 50 #80-10, Medellín',
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

    private function crearProductosBasicos()
    {
        $productos = [
            [
                'Codigo' => 'PROD001',
                'Nombre' => 'Producto Ejemplo 1',
                'Stock' => 50,
                'Proveedor' => 'Proveedor A'
            ],
            [
                'Codigo' => 'PROD002',
                'Nombre' => 'Producto Ejemplo 2',
                'Stock' => 30,
                'Proveedor' => 'Proveedor B'
            ],
            [
                'Codigo' => 'PROD003',
                'Nombre' => 'Producto Ejemplo 3',
                'Stock' => 25,
                'Proveedor' => 'Proveedor C'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(
                ['Codigo' => $producto['Codigo']],
                $producto
            );
        }
    }

    private function crearComprasBasicas()
    {
        $clientes = User::where('role', 'cliente')->get();
        $productos = Producto::all();
        $estados = ['pendiente', 'procesando', 'enviado', 'entregado'];

        for ($i = 0; $i < 10; $i++) {
            $cliente = $clientes->random();
            $estado = $estados[array_rand($estados)];
            $fecha = Carbon::now()->subDays(rand(0, 30));
            $total = rand(100000, 2000000);

            Compra::create([
                'ID_Usuario' => $cliente->id,
                'ID_MedioDePago' => 1,
                'Fecha_De_Compra' => $fecha,
                'Fecha_Compra' => $fecha,
                'Tiempo_De_Entrega' => $fecha->addDays(rand(1, 7)),
                'Total' => $total,
                'Estado' => $estado
            ]);
        }
    }

    private function crearVentasBasicas()
    {
        $clientes = User::where('role', 'cliente')->get();

        for ($i = 0; $i < 8; $i++) {
            $cliente = $clientes->random();
            $fecha = Carbon::now()->subDays(rand(0, 30));

            Venta::create([
                'ID_Usuario' => $cliente->id,
                'fecha_venta' => $fecha
            ]);
        }
    }

    private function crearPagosBasicos()
    {
        $compras = Compra::all();
        $estados = ['pendiente', 'aprobado', 'rechazado'];

        foreach ($compras as $compra) {
            $estado = $estados[array_rand($estados)];
            $fechaCompra = Carbon::parse($compra->Fecha_De_Compra);
            $fechaPago = $fechaCompra->addDays(rand(0, 2));

            Pago::create([
                'Fecha_Pago' => $fechaPago,
                'Numero_Factura' => $compra->ID_Compras,
                'Fecha_Factura' => $fechaCompra,
                'Monto' => $compra->Total,
                'Estado_Pago' => $estado
            ]);
        }
    }
}
