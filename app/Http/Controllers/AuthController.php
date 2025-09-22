<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.iniciosesion');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirigir según el rol del usuario
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('perfilad');
            } elseif ($user->role === 'empleado') {
                return redirect()->route('perfilemp');
            } else {
                return redirect()->route('perfillcli');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('frontend.creacioncuenta');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipo-doc' => 'required|string|in:CC,TI,CE',
            'documento' => 'required|string|max:20',
            'correo' => 'required|string|email|max:255|unique:users,email',
            'confirmar-correo' => 'required|string|email|same:correo',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el nombre completo
        $name = $request->nombre . ' ' . $request->apellido;

        $user = User::create([
            'name' => $name,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'role' => 'cliente', // Por defecto todos son clientes
        ]);

        Auth::login($user);

        return redirect()->route('perfillcli');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
