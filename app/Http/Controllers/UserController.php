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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:50',
            'document_number' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|string|in:admin,empleado,cliente',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('perfilad')->with('success', 'Usuario creado correctamente');
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
        $user->role = $request->role;
        $user->save();

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
        return view('frontend.perfilcli', compact('productos', 'mediosPagoCount', 'comprasCount'));
    }
}
