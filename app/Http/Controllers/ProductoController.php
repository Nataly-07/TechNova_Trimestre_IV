<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Caracteristicas;
use Illuminate\Support\Facades\Schema;

class ProductoController extends Controller
{
    /**
     * Listar productos y mostrar la vista.
     */
    public function index()
    {
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.inventarioproductos', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('frontend.inventarioproductos');
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(Request $request)
    {
        try {
            // Validación de todos los campos
$request->validate([
    'Codigo' => 'required|string|max:50',
    'Nombre' => 'required|string|max:100',
    'Imagen' => 'nullable|url',
    'Categoria' => 'required|string|max:100',
    'Color' => 'required|string|max:100',
    'Descripcion' => 'nullable|string',
    'Precio_Compra' => 'required|numeric',
    'Precio_Venta' => 'required|numeric',
    'Marca' => 'required|string|max:100',
    'Ingreso' => 'required|integer|min:0',
    'Salida' => 'nullable|integer|min:0',
]);

            // Verificar si el código ya existe
            $existingProduct = Producto::where('Codigo', $request->input('Codigo'))->first();
            if ($existingProduct) {
                if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya existe un producto con este código',
                        'errors' => ['Codigo' => ['El código ya está en uso']]
                    ], 422);
                }
                return redirect()->back()->withErrors(['Codigo' => 'El código ya está en uso'])->withInput();
            }

            // Guardar características
            $caracteristicas = Caracteristicas::create([
                'Categoria' => $request->input('Categoria'),
                'Color' => $request->input('Color'),
                'Descripcion' => $request->input('Descripcion'),
                'Precio_Compra' => $request->input('Precio_Compra'),
                'Precio_Venta' => $request->input('Precio_Venta'),
                'Marca' => $request->input('Marca'),
            ]);

            // Calcular stock (Ingreso - Salida)
            $ingreso = $request->input('Ingreso', 0);
            $salida = $request->input('Salida', 0);
            $stock = $ingreso - $salida;
            
            // Log para debugging
            \Log::info('Datos recibidos:', [
                'Ingreso' => $ingreso,
                'Salida' => $salida,
                'Stock' => $stock
            ]);

            // Guardar producto
            Producto::create([
                'Codigo' => $request->input('Codigo'),
                'Nombre' => $request->input('Nombre'),
                'Imagen' => $request->input('Imagen'),
                'ID_Caracteristicas' => $caracteristicas->ID_Caracteristicas,
                'Stock' => $stock,
                'Ingreso' => $ingreso,
                'Salida' => $salida,
            ]);

            // Responder según el tipo de solicitud
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado correctamente'
                ]);
            }

            return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al guardar producto: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al guardar el producto')->withInput();
        }
    }

    /**
     * Eliminar un producto.
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            // Guardar referencia a las características antes de eliminar el producto
            $caracteristicas = $producto->caracteristicas;

            // Eliminar el producto primero (debido a la restricción de clave externa)
            $producto->delete();

            // Luego eliminar las características si existen
            if ($caracteristicas) {
                $caracteristicas->delete();
            }

            // Responder según el tipo de solicitud
            $request = request();
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto eliminado correctamente'
                ]);
            }

            return redirect()->route('productos.index', ['deleted' => 'success'])->with('success', 'Producto eliminado correctamente');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al eliminar producto: ' . $e->getMessage());

            $request = request();
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el producto'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al eliminar el producto');
        }
    }

    /**
     * Mostrar el formulario de edición de un producto.
     */
    public function edit($id)
    {
        $producto = Producto::with('caracteristicas')->findOrFail($id);
        return view('frontend.editarproducto', compact('producto'));
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, $id)
    {
        try {
$request->validate([
    'Codigo' => 'required|string|max:50',
    'Nombre' => 'required|string|max:100',
    'Imagen' => 'nullable|url',
    'Categoria' => 'required|string|max:100',
    'Color' => 'required|string|max:100',
    'Descripcion' => 'nullable|string',
    'Precio_Compra' => 'required|numeric',
    'Precio_Venta' => 'required|numeric',
    'Marca' => 'required|string|max:100',
    'Ingreso' => 'required|integer|min:0',
    'Salida' => 'nullable|integer|min:0',
    // Stock no se valida porque se calcula automáticamente
]);

            $producto = Producto::findOrFail($id);

            if ($producto->ID_Caracteristicas) {
                $caracteristicas = Caracteristicas::findOrFail($producto->ID_Caracteristicas);
                $caracteristicas->update([
                    'Categoria' => $request->input('Categoria'),
                    'Color' => $request->input('Color'),
                    'Descripcion' => $request->input('Descripcion'),
                    'Precio_Compra' => $request->input('Precio_Compra'),
                    'Precio_Venta' => $request->input('Precio_Venta'),
                    'Marca' => $request->input('Marca'),
                ]);
            } else {
                // If no caracteristicas exist, create them
                $caracteristicas = Caracteristicas::create([
                    'Categoria' => $request->input('Categoria'),
                    'Color' => $request->input('Color'),
                    'Descripcion' => $request->input('Descripcion'),
                    'Precio_Compra' => $request->input('Precio_Compra'),
                    'Precio_Venta' => $request->input('Precio_Venta'),
                    'Marca' => $request->input('Marca'),
                ]);
                $producto->ID_Caracteristicas = $caracteristicas->ID_Caracteristicas;
                $producto->save();
            }

            // Calcular stock (Ingreso - Salida)
            $ingreso = $request->input('Ingreso', 0);
            // La salida se mantiene como está (no se modifica manualmente, solo por compras)
            $salida = $producto->Salida ?? 0;
            $stock = $ingreso - $salida;
            
            // Log para debugging
            \Log::info('Datos de actualización:', [
                'Ingreso' => $ingreso,
                'Salida' => $salida,
                'Stock' => $stock,
                'Producto ID' => $producto->ID_Producto
            ]);

            // Preparar datos para actualización
            $updateData = [
                'Codigo' => $request->input('Codigo'),
                'Nombre' => $request->input('Nombre'),
                'Imagen' => $request->input('Imagen'),
                'Stock' => $stock,
            ];

            // Solo agregar Ingreso y Salida si los campos existen en la base de datos
            if (Schema::hasColumn('producto', 'Ingreso')) {
                $updateData['Ingreso'] = $ingreso;
            }
            if (Schema::hasColumn('producto', 'Salida')) {
                // Salida no se actualiza manualmente, solo por el sistema de compras
            }

            $producto->update($updateData);

            // Responder según el tipo de solicitud
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente'
                ]);
            }

            return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al actualizar producto: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar la página de productos (index).
     */
    public function showIndex()
    {
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.index', compact('productos'));
    }

    /**
     * Mostrar el dashboard de empleado.
     */
    public function showEmployeeDashboard()
    {
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.inventarioempleados', compact('productos'));
    }

    /**
     * Mostrar productos filtrados por marca.
     */
    public function marcaApple()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'Apple');
            })->get();

        return view('frontend.marca-apple', compact('productos'));
    }

    public function marcaSamsung()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'Samsung');
            })->get();

        return view('frontend.marca-samsung', compact('productos'));
    }

    public function marcaMotorola()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'Motorola');
            })->get();

        return view('frontend.marca-motorola', compact('productos'));
    }

    public function marcaXiaomi()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'Xiaomi');
            })->get();

        return view('frontend.marca-xiaomi', compact('productos'));
    }

    public function marcaOppo()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'OPPO');
            })->get();

        return view('frontend.marca-oppo', compact('productos'));
    }

    public function marcaLenovo()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Marca', 'Lenovo');
            })->get();

        return view('frontend.marca-lenovo', compact('productos'));
    }

    /**
     * Mostrar productos filtrados por categoría.
     */
    public function celulares()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Categoria', 'Celulares');
            })->get();

        return view('frontend.celulares', compact('productos'));
    }

    public function portatiles()
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function ($query) {
                $query->where('Categoria', 'Portátiles');
            })->get();

        return view('frontend.portatiles', compact('productos'));
    }

    // Método ofertas eliminado según solicitud del usuario
}
