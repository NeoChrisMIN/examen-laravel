<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use App\Models\Entrada;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
{
    // Obtener parámetros de ordenamiento de la URL
    $sort = $request->query('sort', 'id'); 
    $order = $request->query('order', 'asc');

    // Validar que el campo de ordenamiento sea válido
    $validSortColumns = ['id', 'user_id', 'categoria_id', 'titulo', 'descripcion', 'fecha'];
    if (!in_array($sort, $validSortColumns)) {
        $sort = 'id'; // Si el campo no es válido, volver al campo predeterminado
    }

    // Obtener todas las categorías disponibles
    $categorias = Categoria::all();

    // Obtener el usuario actual
    $user = Auth::user();

    // Obtener las entradas según el tipo de usuario y la categoría seleccionada
    $query = Entrada::query();
    
    if ($request->has('categoria')) {
        $categoriaId = $request->input('categoria');
        if ($categoriaId !== '') {
            $query->where('categoria_id', $categoriaId);
        }
    }

    if ($user->rol === 'admin') {
        // Usuario administrador: obtener todas las entradas
        $entradas = $query->orderBy($sort, $order)->paginate(10);
    } else {
        // Usuario regular: obtener solo sus propias entradas
        $entradas = $query->where('user_id', $user->id)
            ->orderBy($sort, $order)
            ->paginate(10);
    }

    // Renderizar la vista blade en HTML con las entradas y las categorías
    $html = View::make('entradas.index', compact('entradas', 'categorias'))->render();

    // Crear una instancia de Dompdf
    $dompdf = new Dompdf();

    // Cargar el contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Configurar opciones, como tamaño de papel, orientación, etc.
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Descargar el PDF generado
    return $dompdf->stream('entradas.pdf');
}
}
