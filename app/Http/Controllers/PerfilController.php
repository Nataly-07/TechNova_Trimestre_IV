<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules;

class PerfilController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.editar-perfil', compact('user'));
    }

    /**
     * Actualizar perfil del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'tipo_doc' => ['required', 'string', 'in:CC,TI,CE'],
            'documento' => ['required', 'string', 'max:20', 'unique:users,document_number,' . $user->id],
            'correo' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'name' => $request->nombre . ' ' . $request->apellido,
            'first_name' => $request->nombre,
            'last_name' => $request->apellido,
            'document_type' => $request->tipo_doc,
            'document_number' => $request->documento,
            'email' => $request->correo,
            'phone' => $request->telefono,
            'address' => $request->direccion,
        ]);

        // Actualizar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Redirigir según el rol
        if ($user->role === 'admin') {
            return redirect()->route('perfilad')->with('success', 'Perfil actualizado exitosamente.');
        } elseif ($user->role === 'empleado') {
            return redirect()->route('perfilemp')->with('success', 'Perfil actualizado exitosamente.');
        } else {
            return redirect()->route('perfillcli')->with('success', 'Perfil actualizado exitosamente.');
        }
    }

    /**
     * Mostrar confirmación de eliminación de cuenta
     */
    public function confirmDelete()
    {
        $user = Auth::user();
        return view('frontend.confirmar-eliminar-cuenta', compact('user'));
    }

    /**
     * Eliminar cuenta del usuario
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Cerrar sesión antes de eliminar
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Eliminar usuario
        $user->delete();

        return redirect()->route('frontend.login')->with('success', 'Tu cuenta ha sido eliminada exitosamente.');
    }
}