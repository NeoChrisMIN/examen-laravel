<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EntradaController extends Controller
{

    /*public function index()
    {
        $entradas = Entrada::paginate(10); // Obtener datos paginados con 10 elementos por página

        return view('entradas.index', compact('entradas'));
    }*/

    
    public function index(Request $request)
    {
        // Obtener la fecha a filtrar (si está presente en la solicitud)
        $fechaFiltro = $request->input('fecha');
        // Obtener el estado a filtrar (si está presente en la solicitud)
        $estadoFiltro = $request->input('estado');

        // Validar parámetros de ordenamiento de la URL
        $sort = $request->query('sort', 'fecha'); 
        $order = $request->query('order', 'asc');

        // Validar que el campo de ordenamiento sea válido
        $validSortColumns = ['id', 'user_id', 'categoria_id', 'titulo', 'descripcion', 'fecha'];
        if (!in_array($sort, $validSortColumns)) {
            $sort = 'fecha'; // Si el campo no es válido, ordenar por fecha por defecto
        }

        // Obtener el usuario actual
        $user = Auth::user();

        // Obtener todas las categorías disponibles
        $categorias = Categoria::all();

        // Construir la consulta base de las entradas
        $query = Entrada::query();

        // Filtrar por fecha si se ha especificado en la solicitud
        if ($fechaFiltro) {
            // Convertir la fecha de filtro a formato Carbon
            $fecha = Carbon::createFromFormat('Y-m-d', $fechaFiltro);

            // Filtrar las entradas por fecha específica
            $query->whereDate('fecha', $fecha);
        }

        // Filtrar por categoría si se ha especificado en la solicitud
        if ($request->has('categoria')) {
            $categoriaId = $request->input('categoria');
            if ($categoriaId !== '') {
                $query->where('categoria_id', $categoriaId);
            }
        }

        // Filtrar por estado si se ha especificado en la solicitud
        if ($estadoFiltro) {
            if($estadoFiltro == "en_proceso") $query->where('estado', "en proceso");
            else $query->where('estado', $estadoFiltro);
        }

        // Determinar la lógica de obtención de entradas según el rol del usuario
        if ($user->rol === 'admin') {
            // Rol admin: obtener todas las entradas
            $entradas = $query->orderBy($sort, $order)->paginate(10);
        } else {
            // Rol user: obtener solo sus entradas
            $entradas = $query->where('user_id', $user->id)
                ->orderBy($sort, $order)
                ->paginate(10);
        }

        return view('entradas.index', compact('entradas', 'categorias'));
    }

    public function show($id)
    {
        $entrada = Entrada::find($id);

        if (!$entrada) {
            abort(404);
        }

        return view('entradas.detalle', compact('entrada'));
    }
    
    // --------------------------------------------------------------------------------------------------

    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $categorias = Categoria::all(); // Obtener todas las categorías disponibles

        return view('entradas.editar', compact('entrada', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
        ]);
    
        // Redireccionar de vuelta si la validación falla
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Obtener la entrada a actualizar
        $entrada = Entrada::findOrFail($id);
    
        // Actualizar los campos de la entrada
        $entrada->categoria_id = $request->categoria_id;
        $entrada->titulo = $request->titulo;
        $entrada->descripcion = $request->descripcion;
        $entrada->fecha = $request->fecha;
        $entrada->hora = $request->hora;
        $entrada->lugar = $request->lugar;
        $entrada->prioridad = $request->prioridad;
        $entrada->estado = $request->estado;
    
        // Guardar la imagen si se ha subido una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($entrada->imagen) {
                Storage::delete('public/' . $entrada->imagen);
            }
    
            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('public/entrada');
            $entrada->imagen = str_replace('public/', '', $imagenPath);
        }
    
        // Guardar la entrada actualizada en la base de datos
        $entrada->save();
    
        // Redireccionar a la página de listado de entradas con un mensaje de éxito
        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada exitosamente.');
    }

    public function eliminar($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada exitosamente.');
    }

    // -------------------------------------------------------------------------------------------------------

    public function crear()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        $categorias = Categoria::all(); // Obtener todas las categorías

        return view('entradas.crear', compact('usuarios', 'categorias'));
    }

    public function guardar(Request $request)
    {
        // Validar los datos recibidos del formulario
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',

        ]);

        // Redireccionar de vuelta si la validación falla
        if ($validator->fails()) {
            return redirect()->route('entradas.crear')
                ->withErrors($validator)
                ->withInput();
        }

        // Procesar y guardar la nueva entrada en la base de datos
        $entrada = new Entrada();
        $entrada->user_id = $request->user_id;
        $entrada->categoria_id = $request->categoria_id;
        $entrada->titulo = $request->titulo;
        $entrada->descripcion = $request->descripcion;
        $entrada->fecha = $request->fecha;
        $entrada->hora = $request->hora;
        $entrada->lugar = $request->lugar;
        $entrada->prioridad = $request->prioridad;
        $entrada->estado = $request->estado;

        // Subir y guardar la imagen
        $imagenPath = $request->file('imagen')->store('public/entrada');
        $entrada->imagen = str_replace('public/', '', $imagenPath);

        $entrada->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada creada exitosamente.');
    }
}
