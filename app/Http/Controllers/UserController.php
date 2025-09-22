<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('frontend.usuarios', compact('users'));
    }

    public function create()
    {
        return view('frontend.agregarusuario');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'tipo-doc' => 'required|string|in:CC,TI,CE',
            'documento' => [
                'required',
                'string',
                'min:7',
                'max:20',
                'regex:/^\d+$/',
                'unique:users,document_number'
            ],
            'correo' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users,email'
            ],
            'telefono' => [
                'required',
                'string',
                'size:10',
                'regex:/^\d+$/'
            ],
            'direccion' => [
                'required',
                'string',
                'min:8',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/'
            ],
            'role' => 'required|string|in:admin,empleado,cliente',
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'apellido.min' => 'El apellido debe tener al menos 2 caracteres.',
            'documento.regex' => 'El documento solo puede contener números.',
            'documento.min' => 'El documento debe tener al menos 7 dígitos.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'telefono.size' => 'El teléfono debe tener exactamente 10 dígitos.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'direccion.min' => 'La dirección debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->nombre . ' ' . $request->apellido,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'first_name' => $request->nombre,
            'last_name' => $request->apellido,
            'document_type' => $request->{'tipo-doc'},
            'document_number' => $request->documento,
            'phone' => $request->telefono,
            'address' => $request->direccion,
            'role' => $request->role,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('frontend.editar-usuario', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role' => 'required|string|in:admin,empleado,cliente',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Solo actualizar el rol
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Rol de usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index', ['deleted' => 'success'])->with('success', 'Usuario eliminado correctamente');
    }

    public function perfilad()
    {
        $users = User::all();
        $productos = \App\Models\Producto::with('caracteristicas')->get();
        $proveedores = \App\Models\Proveedor::all();
        
        // Contar reportes disponibles (productos, usuarios, ventas)
        $reportesDisponibles = 3; // productos, usuarios, ventas
        
        return view('frontend.perfilad', compact('users', 'productos', 'proveedores', 'reportesDisponibles'));
    }

    public function perfilEmpleado()
    {
        $productos = \App\Models\Producto::with('caracteristicas')->get();
        return view('frontend.perfilep', compact('productos'));
    }

    public function perfilCliente()
    {
        $productos = \App\Models\Producto::with('caracteristicas')->get();
        $mediosPagoCount = \App\Models\UserPaymentMethod::where('user_id', auth()->id())->count();
        $comprasCount = \App\Models\Compra::where('ID_Usuario', auth()->id())->count();
        
        // Contar favoritos del usuario
        $favoritosCount = \App\Models\Favorito::where('user_id', auth()->id())->count();
        
        // Contar productos en el carrito del usuario
        $carritoCount = \App\Models\DetalleCarrito::whereHas('carrito', function($query) {
            $query->where('ID_Usuario', auth()->id());
        })->count();
        
        // Contar pedidos del usuario
        $pedidosCount = \App\Models\Venta::where('ID_Usuario', auth()->id())->count();
        
        // Contar mensajes pendientes (asumiendo que hay un modelo Mensaje)
        $mensajesCount = 0; // Por ahora 0, se puede implementar cuando exista el modelo
        
        return view('frontend.perfilcli', compact(
            'productos', 
            'mediosPagoCount', 
            'comprasCount',
            'favoritosCount',
            'carritoCount',
            'pedidosCount',
            'mensajesCount'
        ));
    }
}
