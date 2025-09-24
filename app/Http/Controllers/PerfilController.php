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
        
        // Validación condicional según el rol del usuario
        $validationRules = [
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        // Solo validar campos editables según el rol
        if ($user->role !== 'empleado') {
            $validationRules['nombre'] = ['required', 'string', 'max:255'];
            $validationRules['apellido'] = ['required', 'string', 'max:255'];
            $validationRules['correo'] = ['required', 'email', 'max:255', 'unique:users,email,' . $user->id];
        } else {
            // Para empleados, estos campos son opcionales ya que no se pueden editar
            $validationRules['nombre'] = ['nullable', 'string', 'max:255'];
            $validationRules['apellido'] = ['nullable', 'string', 'max:255'];
            $validationRules['correo'] = ['nullable', 'email', 'max:255'];
        }

        // Campos de documento siempre no editables
        $validationRules['tipo_doc'] = ['nullable', 'string', 'in:CC,TI,CE'];
        $validationRules['documento'] = ['nullable', 'string', 'max:20'];

        $request->validate($validationRules);

        // Actualizar solo los campos editables según el rol
        $updateData = [
            'phone' => $request->telefono,
            'address' => $request->direccion,
        ];

        // Solo actualizar campos editables para clientes y administradores
        if ($user->role !== 'empleado') {
            $updateData['name'] = $request->nombre . ' ' . $request->apellido;
            $updateData['first_name'] = $request->nombre;
            $updateData['last_name'] = $request->apellido;
            $updateData['email'] = $request->correo;
        }

        $user->update($updateData);

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