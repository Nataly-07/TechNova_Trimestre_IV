<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;

class ProveedorController extends Controller
{
    /**
     * Mostrar la lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('frontend.proveedores', compact('proveedores'));
    }

    /**
     * Mostrar el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        $productos = Producto::all();
        // Usar vista de debug si la ruta es debug
        if (request()->routeIs('proveedores.debug.create')) {
            return view('frontend.crear-proveedor-debug', compact('productos'));
        }
        return view('frontend.crear-proveedor', compact('productos'));
    }

    /**
     * Guardar un nuevo proveedor.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Datos recibidos:', $request->all());
            
            $request->validate([
                'Identificacion' => 'required|string|max:50',
                'Nombre' => 'required|string|max:100',
                'Telefono' => 'required|string|max:10',
                'Correo' => 'required|email|max:100',
                'ID_producto' => 'nullable|integer|exists:producto,ID_Producto'
            ]);

            // Limpiar el campo ID_producto si está vacío
            $idProducto = $request->input('ID_producto');
            if (empty($idProducto) || $idProducto === '') {
                $idProducto = null;
            }

            \Log::info('Validación pasada correctamente');

            // Verificar si la identificación ya existe
            $existingProveedor = Proveedor::where('Identificacion', $request->input('Identificacion'))->first();
            if ($existingProveedor) {
                \Log::info('Proveedor ya existe con identificación: ' . $request->input('Identificacion'));
                return redirect()->back()->withErrors(['Identificacion' => 'Ya existe un proveedor con esta identificación'])->withInput();
            }

            \Log::info('Creando proveedor...');
            $proveedor = Proveedor::create([
                'Identificacion' => $request->input('Identificacion'),
                'Nombre' => $request->input('Nombre'),
                'Telefono' => $request->input('Telefono'),
                'Correo' => $request->input('Correo'),
                'ID_producto' => $idProducto,
                'estado' => 'activo'
            ]);

            \Log::info('Proveedor creado con ID: ' . $proveedor->ID_Proveedor);
            
            // Redirigir según la ruta
            if (request()->routeIs('proveedores.debug.store')) {
                return redirect()->route('proveedores.debug')->with('success', 'Proveedor creado correctamente');
            }
            return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error al guardar proveedor: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error al guardar el proveedor: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar el formulario de edición de un proveedor.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $productos = Producto::all();
        return view('frontend.editar-proveedor', compact('proveedor', 'productos'));
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'Identificacion' => 'required|string|max:50',
                'Nombre' => 'required|string|max:100',
                'Telefono' => 'required|string|max:10',
                'Correo' => 'required|email|max:100',
                'ID_producto' => 'nullable|integer|exists:producto,ID_Producto'
            ]);

            // Limpiar el campo ID_producto si está vacío
            $idProducto = $request->input('ID_producto');
            if (empty($idProducto) || $idProducto === '') {
                $idProducto = null;
            }

            $proveedor = Proveedor::findOrFail($id);

            // Verificar si la identificación ya existe en otro proveedor
            $existingProveedor = Proveedor::where('Identificacion', $request->input('Identificacion'))
                ->where('ID_Proveedor', '!=', $id)
                ->first();
            
            if ($existingProveedor) {
                return redirect()->back()->withErrors(['Identificacion' => 'Ya existe un proveedor con esta identificación'])->withInput();
            }

            $proveedor->update([
                'Identificacion' => $request->input('Identificacion'),
                'Nombre' => $request->input('Nombre'),
                'Telefono' => $request->input('Telefono'),
                'Correo' => $request->input('Correo'),
                'ID_producto' => $idProducto,
                'estado' => $request->input('estado', 'activo')
            ]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al actualizar proveedor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el proveedor')->withInput();
        }
    }

    /**
     * Cambiar el estado de un proveedor (activar/desactivar).
     */
    public function cambiarEstado($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            
            // Cambiar el estado
            $nuevoEstado = $proveedor->estado === 'activo' ? 'inactivo' : 'activo';
            $proveedor->update(['estado' => $nuevoEstado]);

            $mensaje = $nuevoEstado === 'activo' ? 'Proveedor activado correctamente' : 'Proveedor desactivado correctamente';
            return redirect()->route('proveedores.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al cambiar estado del proveedor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cambiar el estado del proveedor');
        }
    }

    /**
     * Activar un proveedor.
     */
    public function activar($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->update(['estado' => 'activo']);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor activado correctamente');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al activar proveedor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al activar el proveedor');
        }
    }

    /**
     * Desactivar un proveedor.
     */
    public function desactivar($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->update(['estado' => 'inactivo']);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor desactivado correctamente');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al desactivar proveedor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al desactivar el proveedor');
        }
    }
}