<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('frontend.iniciosesion');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Si el usuario viene de una página de productos, redirigir al catálogo autenticado
            $intended = $request->session()->get('url.intended');
            if ($intended && (str_contains($intended, '/celulares') || str_contains($intended, '/portatiles') || str_contains($intended, '/marca/'))) {
                $request->session()->forget('url.intended');
                return redirect()->route('catalogo.autenticado');
            }
            
            // Redirección normal por roles
            if ($user && $user->role === 'admin') {
                return redirect()->route('perfilad');
            } elseif ($user && $user->role === 'empleado') {
                return redirect()->route('perfilemp');
            } else {
                return redirect()->route('catalogo.autenticado');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('frontend.creacioncuenta');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'tipo-doc' => ['required', 'string', 'in:CC,TI,CE'],
            'documento' => ['required', 'string', 'max:20', 'unique:users,document_number'],
            'correo' => ['required', 'email', 'max:255', 'unique:users,email'],
            'confirmar-correo' => ['required', 'email', 'same:correo'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->nombre . ' ' . $request->apellido,
            'first_name' => $request->nombre,
            'last_name' => $request->apellido,
            'document_type' => $request->input('tipo-doc'),
            'document_number' => $request->documento,
            'email' => $request->correo,
            'phone' => $request->telefono,
            'address' => $request->direccion,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ]);

        // No login automatico, redirigir a login
        return redirect()->route('frontend.login')->with('success', 'Cuenta creada exitosamente. Por favor, inicia sesión.');
    }

    // Procesar logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la página de login en lugar de index
        return redirect()->route('frontend.login');
    }
}
