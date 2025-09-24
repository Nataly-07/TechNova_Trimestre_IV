<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\User;
use App\Models\Venta;
use App\Models\Compra;
use App\Models\Pago;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;

class NotificacionService
{
    /**
     * Crear notificación de bienvenida para un nuevo usuario
     */
    public static function crearNotificacionBienvenida($userId)
    {
        return Notificacion::crearNotificacion(
            $userId,
            '¡Bienvenido a Technova!',
            'Gracias por registrarte en nuestra plataforma. Explora nuestros productos y encuentra las mejores ofertas.',
            'bienvenida',
            'bx-user-check'
        );
    }

    /**
     * Crear notificación cuando se realiza una compra
     */
    public static function crearNotificacionCompra($userId, $compraId)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Compra realizada exitosamente',
            'Tu compra ha sido procesada correctamente. Recibirás un correo de confirmación pronto.',
            'compra',
            'bx-shopping-bag',
            ['compra_id' => $compraId]
        );
    }

    /**
     * Crear notificación cuando se envía un pedido
     */
    public static function crearNotificacionPedidoEnviado($userId, $ventaId)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Tu pedido ha sido enviado',
            'Tu pedido está en camino. Recibirás un seguimiento por correo electrónico.',
            'pedido',
            'bx-package',
            ['venta_id' => $ventaId]
        );
    }

    /**
     * Crear notificación cuando se entrega un pedido
     */
    public static function crearNotificacionPedidoEntregado($userId, $ventaId)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Pedido entregado',
            'Tu pedido ha sido entregado exitosamente. ¡Esperamos que disfrutes tu compra!',
            'pedido',
            'bx-check-circle',
            ['venta_id' => $ventaId]
        );
    }

    /**
     * Crear notificación de oferta especial
     */
    public static function crearNotificacionOferta($userId, $titulo, $mensaje, $productoId = null)
    {
        return Notificacion::crearNotificacion(
            $userId,
            $titulo,
            $mensaje,
            'promocion',
            'bx-gift',
            $productoId ? ['producto_id' => $productoId] : null
        );
    }

    /**
     * Crear notificación de nuevo producto
     */
    public static function crearNotificacionNuevoProducto($userId, $productoId, $nombreProducto)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Nuevo producto disponible',
            "Hemos agregado '{$nombreProducto}' a nuestro catálogo. ¡Échale un vistazo!",
            'producto',
            'bx-plus-circle',
            ['producto_id' => $productoId, 'nombre_producto' => $nombreProducto]
        );
    }

    /**
     * Crear notificación de recordatorio de pago
     */
    public static function crearNotificacionRecordatorioPago($userId)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Recordatorio de pago',
            'Tu método de pago por defecto expirará pronto. Actualiza tu información para evitar interrupciones.',
            'pago',
            'bx-credit-card'
        );
    }

    /**
     * Crear notificación de soporte técnico
     */
    public static function crearNotificacionSoporte($userId, $mensaje)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Soporte técnico',
            $mensaje,
            'soporte',
            'bx-headphone'
        );
    }

    /**
     * Crear notificación de producto en oferta
     */
    public static function crearNotificacionProductoOferta($userId, $productoId, $nombreProducto, $descuento)
    {
        return Notificacion::crearNotificacion(
            $userId,
            '¡Oferta especial!',
            "El producto '{$nombreProducto}' tiene un descuento del {$descuento}%. ¡No te lo pierdas!",
            'promocion',
            'bx-tag',
            ['producto_id' => $productoId, 'nombre_producto' => $nombreProducto, 'descuento' => $descuento]
        );
    }

    /**
     * Crear notificación de pago procesado
     */
    public static function crearNotificacionPagoProcesado($userId, $pagoId, $monto)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Pago procesado exitosamente',
            "Tu pago de $" . number_format($monto, 0, ',', '.') . " ha sido procesado correctamente. Tu pedido está siendo preparado.",
            'pago',
            'bx-check-circle',
            ['pago_id' => $pagoId, 'monto' => $monto]
        );
    }

    /**
     * Crear notificación de pago pendiente
     */
    public static function crearNotificacionPagoPendiente($userId, $pagoId, $monto)
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Pago pendiente de confirmación',
            "Tu pago de $" . number_format($monto, 0, ',', '.') . " está pendiente de confirmación. Te notificaremos cuando sea procesado.",
            'pago',
            'bx-time-five',
            ['pago_id' => $pagoId, 'monto' => $monto]
        );
    }

    /**
     * Crear notificación de pago fallido
     */
    public static function crearNotificacionPagoFallido($userId, $pagoId, $monto, $razon = '')
    {
        return Notificacion::crearNotificacion(
            $userId,
            'Pago no procesado',
            "Tu pago de $" . number_format($monto, 0, ',', '.') . " no pudo ser procesado. " . $razon . " Por favor, intenta nuevamente.",
            'pago',
            'bx-x-circle',
            ['pago_id' => $pagoId, 'monto' => $monto, 'razon' => $razon]
        );
    }

    /**
     * Crear notificaciones automáticas basadas en eventos del sistema
     */
    public static function procesarEventosAutomaticos()
    {
        try {
            // Crear notificaciones de bienvenida para usuarios nuevos (últimos 7 días)
            $usuariosNuevos = User::where('created_at', '>=', now()->subDays(7))
                ->whereDoesntHave('notificaciones', function($query) {
                    $query->where('tipo', 'bienvenida');
                })
                ->get();

            foreach ($usuariosNuevos as $usuario) {
                self::crearNotificacionBienvenida($usuario->id);
            }

            // Crear notificaciones para compras recientes (últimas 24 horas)
            $comprasRecientes = Compra::where('Fecha_Compra', '>=', now()->subHours(24)->toDateString())
                ->whereDoesntHave('notificaciones')
                ->with('user')
                ->get();

            foreach ($comprasRecientes as $compra) {
                if ($compra->user) {
                    self::crearNotificacionCompra($compra->user->id, $compra->ID_Compras);
                }
            }

            // Crear notificaciones para ventas recientes (últimas 24 horas)
            $ventasRecientes = Venta::where('fecha_venta', '>=', now()->subHours(24)->toDateString())
                ->whereDoesntHave('notificaciones')
                ->with('usuario')
                ->get();

            foreach ($ventasRecientes as $venta) {
                if ($venta->usuario) {
                    self::crearNotificacionPedidoEnviado($venta->usuario->id, $venta->ID_Ventas);
                }
            }

            // Crear notificaciones para pagos procesados (últimas 24 horas)
            $pagosProcesados = Pago::where('Fecha_Pago', '>=', now()->subHours(24)->toDateString())
                ->where('Estado_Pago', 'procesado')
                ->whereDoesntHave('notificaciones')
                ->get();

            foreach ($pagosProcesados as $pago) {
                // Buscar el usuario asociado a través de las ventas
                $venta = Venta::whereHas('detalles', function($query) use ($pago) {
                    $query->whereHas('mediosPago', function($q) use ($pago) {
                        $q->where('ID_Pagos', $pago->ID_Pagos);
                    });
                })->with('usuario')->first();

                if ($venta && $venta->usuario) {
                    self::crearNotificacionPagoProcesado($venta->usuario->id, $pago->ID_Pagos, $pago->Monto);
                }
            }

            // Crear notificaciones para pagos pendientes (últimas 2 horas)
            $pagosPendientes = Pago::where('Fecha_Pago', '>=', now()->subHours(2)->toDateString())
                ->where('Estado_Pago', 'pendiente')
                ->whereDoesntHave('notificaciones')
                ->get();

            foreach ($pagosPendientes as $pago) {
                // Buscar el usuario asociado
                $venta = Venta::whereHas('detalles', function($query) use ($pago) {
                    $query->whereHas('mediosPago', function($q) use ($pago) {
                        $q->where('ID_Pagos', $pago->ID_Pagos);
                    });
                })->with('usuario')->first();

                if ($venta && $venta->usuario) {
                    self::crearNotificacionPagoPendiente($venta->usuario->id, $pago->ID_Pagos, $pago->Monto);
                }
            }

            Log::info('Notificaciones automáticas procesadas exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al procesar notificaciones automáticas: ' . $e->getMessage());
        }
    }

    /**
     * Obtener estadísticas de notificaciones para un usuario
     */
    public static function obtenerEstadisticas($userId)
    {
        $total = Notificacion::where('user_id', $userId)->count();
        $noLeidas = Notificacion::where('user_id', $userId)->where('leida', false)->count();
        $leidas = $total - $noLeidas;

        return [
            'total' => $total,
            'no_leidas' => $noLeidas,
            'leidas' => $leidas
        ];
    }
}
