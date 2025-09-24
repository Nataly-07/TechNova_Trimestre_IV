<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AtencionCliente;
use App\Models\MensajeDirecto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CrearDatosAtencionCliente extends Command
{
    protected $signature = 'atencion-cliente:crear-datos';
    protected $description = 'Crear datos de ejemplo para la sección de atención al cliente';

    public function handle()
    {
        $this->info('Creando datos de ejemplo para atención al cliente...');

        // Crear un cliente de ejemplo si no existe
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente Ejemplo',
                'first_name' => 'Cliente',
                'last_name' => 'Ejemplo',
                'document_type' => 'CC',
                'document_number' => '12345678',
                'phone' => '3001234567',
                'address' => 'Calle 123 #45-67, Bogotá',
                'password' => Hash::make('password'),
                'role' => 'cliente'
            ]
        );

        // Crear consultas de ejemplo
        $consultas = [
            [
                'ID_Usuario' => $cliente->id,
                'Fecha_Consulta' => now()->subDays(5),
                'Tema' => 'Problema con mi pedido #12345',
                'Descripcion' => 'Mi pedido no ha llegado en la fecha estimada. El tracking muestra que está en tránsito desde hace 5 días y no he recibido actualizaciones.',
                'Estado' => 'abierto'
            ],
            [
                'ID_Usuario' => $cliente->id,
                'Fecha_Consulta' => now()->subDays(3),
                'Tema' => 'Producto defectuoso recibido',
                'Descripcion' => 'Recibí un producto que no funciona correctamente. El artículo parece estar dañado y no cumple con las especificaciones descritas en la página.',
                'Estado' => 'en_proceso',
                'Respuesta' => 'Hemos revisado tu consulta y estamos procesando el reembolso. Te contactaremos en las próximas 24 horas.',
                'ID_Empleado_Respuesta' => 1,
                'Fecha_Respuesta' => now()->subDays(2)
            ],
            [
                'ID_Usuario' => $cliente->id,
                'Fecha_Consulta' => now()->subDays(1),
                'Tema' => 'Consulta sobre garantía',
                'Descripcion' => '¿Cuál es la política de garantía para los productos electrónicos? Necesito saber si mi producto está cubierto.',
                'Estado' => 'resuelto',
                'Respuesta' => 'Nuestros productos electrónicos tienen una garantía de 1 año. Tu producto está cubierto y puedes contactarnos para cualquier problema.',
                'ID_Empleado_Respuesta' => 1,
                'Fecha_Respuesta' => now()->subHours(12)
            ]
        ];

        foreach ($consultas as $consulta) {
            AtencionCliente::firstOrCreate(
                [
                    'ID_Usuario' => $consulta['ID_Usuario'],
                    'Tema' => $consulta['Tema']
                ],
                $consulta
            );
        }

        // Crear mensajes directos de ejemplo
        $mensajes = [
            [
                'user_id' => $cliente->id,
                'asunto' => 'Consulta sobre envío',
                'mensaje' => 'Hola, quería saber cuánto tiempo tarda el envío a mi ciudad. ¿Hay alguna forma de acelerar el proceso?',
                'prioridad' => 'normal',
                'estado' => 'enviado',
                'conversation_id' => 'conv_' . uniqid(),
                'sender_type' => 'cliente',
                'sender_id' => $cliente->id,
                'recipient_id' => null,
                'is_read' => false,
                'created_at' => now()->subDays(2)
            ],
            [
                'user_id' => $cliente->id,
                'asunto' => 'Problema con pago',
                'mensaje' => 'Tuve un problema al procesar el pago con mi tarjeta. El sistema me dice que hay un error pero no me da más detalles.',
                'prioridad' => 'alta',
                'estado' => 'leido',
                'conversation_id' => 'conv_' . uniqid(),
                'sender_type' => 'cliente',
                'sender_id' => $cliente->id,
                'recipient_id' => null,
                'is_read' => true,
                'read_at' => now()->subHours(12),
                'created_at' => now()->subDays(1)
            ],
            [
                'user_id' => $cliente->id,
                'asunto' => 'Solicitud de reembolso',
                'mensaje' => 'Necesito solicitar un reembolso por un producto que no cumple con mis expectativas. ¿Cuál es el proceso?',
                'prioridad' => 'urgente',
                'estado' => 'respondido',
                'respuesta' => 'Hemos procesado tu solicitud de reembolso. El dinero será devuelto a tu cuenta en 3-5 días hábiles.',
                'empleado_id' => 1,
                'fecha_respuesta' => now()->subHours(6),
                'conversation_id' => 'conv_' . uniqid(),
                'sender_type' => 'cliente',
                'sender_id' => $cliente->id,
                'recipient_id' => 1,
                'is_read' => true,
                'read_at' => now()->subHours(6),
                'created_at' => now()->subHours(8)
            ]
        ];

        foreach ($mensajes as $mensaje) {
            MensajeDirecto::firstOrCreate(
                [
                    'user_id' => $mensaje['user_id'],
                    'asunto' => $mensaje['asunto']
                ],
                $mensaje
            );
        }

        $this->info('Datos de ejemplo creados exitosamente!');
        $this->info('- 3 consultas de ejemplo');
        $this->info('- 3 mensajes directos de ejemplo');
        $this->info('- Cliente de ejemplo: cliente@example.com');
    }
}
