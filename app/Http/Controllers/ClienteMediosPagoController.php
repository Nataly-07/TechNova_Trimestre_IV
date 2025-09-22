<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPaymentMethod;
use App\Models\MedioPago;

class ClienteMediosPagoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener medios de pago guardados del usuario
        $mediosPagoGuardados = UserPaymentMethod::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Métodos de pago disponibles
        $metodosDisponibles = [
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'nequi' => 'Nequi',
            'pse' => 'PSE',
            'transferencia_bancaria' => 'Transferencia Bancaria',
            'efectivo' => 'Efectivo',
            'paypal' => 'PayPal'
        ];
        
        return view('frontend.cliente.medios-pago', compact('mediosPagoGuardados', 'metodosDisponibles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'datos_pago.nombre' => 'required|string|max:255',
            'datos_pago.numero' => 'required|string|max:20',
            'datos_pago.exp_mes' => 'nullable|string|max:2',
            'datos_pago.exp_anio' => 'nullable|string|max:4',
            'datos_pago.email' => 'nullable|email',
            'datos_pago.telefono' => 'nullable|string|max:20',
        ]);
        
        $user = Auth::user();
        $datosPago = $request->input('datos_pago');
        
        // Crear el medio de pago
        $medioPago = new UserPaymentMethod();
        $medioPago->user_id = $user->id;
        $medioPago->metodo_pago = $request->input('metodo_pago');
        $medioPago->holder_name = $datosPago['nombre'];
        $medioPago->last4 = substr($datosPago['numero'], -4);
        $medioPago->brand = $this->getBrandFromMethod($request->input('metodo_pago'));
        
        // Si es tarjeta, agregar fecha de vencimiento
        if (in_array($request->input('metodo_pago'), ['tarjeta_credito', 'tarjeta_debito'])) {
            $medioPago->exp_month = $datosPago['exp_mes'] ?? null;
            $medioPago->exp_year = $datosPago['exp_anio'] ?? null;
        }
        
        // Si es el primer medio de pago, marcarlo como predeterminado
        $esPrimerMedio = UserPaymentMethod::where('user_id', $user->id)->count() === 0;
        $medioPago->is_default = $esPrimerMedio;
        
        $medioPago->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Medio de pago agregado exitosamente'
        ]);
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        
        $medioPago = UserPaymentMethod::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$medioPago) {
            return response()->json([
                'success' => false,
                'error' => 'Medio de pago no encontrado'
            ], 404);
        }
        
        // Si es el predeterminado, marcar otro como predeterminado
        if ($medioPago->is_default) {
            $otroMedio = UserPaymentMethod::where('user_id', $user->id)
                ->where('id', '!=', $id)
                ->first();
            
            if ($otroMedio) {
                $otroMedio->is_default = true;
                $otroMedio->save();
            }
        }
        
        $medioPago->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Medio de pago eliminado exitosamente'
        ]);
    }
    
    public function setDefault($id)
    {
        $user = Auth::user();
        
        $medioPago = UserPaymentMethod::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$medioPago) {
            return response()->json([
                'success' => false,
                'error' => 'Medio de pago no encontrado'
            ], 404);
        }
        
        // Quitar predeterminado de todos los medios del usuario
        UserPaymentMethod::where('user_id', $user->id)
            ->update(['is_default' => false]);
        
        // Marcar este como predeterminado
        $medioPago->is_default = true;
        $medioPago->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Medio de pago establecido como predeterminado'
        ]);
    }
    
    private function getBrandFromMethod($metodo)
    {
        $brands = [
            'tarjeta_credito' => 'Crédito',
            'tarjeta_debito' => 'Débito',
            'nequi' => 'Nequi',
            'pse' => 'PSE',
            'transferencia_bancaria' => 'Transferencia',
            'efectivo' => 'Efectivo',
            'paypal' => 'PayPal'
        ];
        
        return $brands[$metodo] ?? 'Otro';
    }
}
