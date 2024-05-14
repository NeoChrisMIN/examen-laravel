<!-- index.blade.php -->

<head>
    <meta charset="UTF-8">
    <title>Base de Datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- btn volver -->
    <a class="btn btn-primary mt-3" href="{{ route('dashboard') }}">volver</a>

    <!-- generar pdf -->
    <form action="{{ route('entradas.pdf') }}" method="GET">
        <button type="submit">Generar PDF</button>
    </form>
    
    <!-- combobox para filtrar por categoria -->
    <div class="mt-3 mb-3">
        <form action="{{ route('entradas.index') }}" method="GET">
            <label for="categoria">Filtrar por Categoría:</label>
            <select name="categoria" id="categoria" onchange="this.form.submit()">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- filtrar por dia (fecha)-->
    <div class="mt-3 mb-3">
        <form action="{{ route('entradas.index') }}" method="GET">
            <label for="fecha">Filtrar por Fecha:</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}">
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <!-- filtrar por estado-->
    <div class="mt-3 mb-3">
        <form action="{{ route('entradas.index') }}" method="GET">
            <label for="estado">Filtrar por Estado:</label>
            <select name="estado" id="estado">
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
            </select>
            <button type="submit">Filtrar por Estado</button>
        </form>
    </div>
    

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Datos de tabla de Entradas') }}
        </h2>
    </x-slot>
    
    @if ($entradas->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <!-- Encabezados de la tabla -->
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>ID Usuario</th>
                        <th>ID Categoría</th>
                        <th>Título</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>hora</th>
                        <th>lugar</th>
                        <th>prioridad</th>
                        <th>estado</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $entrada)
                        <tr>
                            <td>{{ $entrada->id }}</td>
                            <td>{{ $entrada->user_id }}</td>
                            <td>{{ $entrada->categoria_id }}</td>
                            <td>{{ $entrada->titulo }}</td>
                            <td><img src="{{ asset('storage/' . $entrada->imagen) }}" alt="Imagen de la entrada" width="50"></td>
                            <td>{{ $entrada->descripcion }}</td>
                            <td>{{ $entrada->fecha }}</td>
                            <td>{{ $entrada->hora }}</td>
                            <td>{{ $entrada->lugar }}</td>
                            <td>{{ $entrada->prioridad }}</td>
                            <td>{{ $entrada->estado }}</td>
                            <td>
                                <a href="{{ route('entradas.show', $entrada->id) }}">Detalle | </a>
                                <!-- HTML con enlace de edición -->
                                <a href="{{ route('entradas.edit', $entrada->id) }}" onclick="return confirm('¿Estás seguro de editar esta entrada?')">Editar</a>
                                
                                <form id="formEliminar{{ $entrada->id }}" action="{{ route('entradas.eliminar', $entrada->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger mt-3" onclick="confirmarEliminar('{{ $entrada->id }}')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Muestra los enlaces de paginación -->
        <div class="d-flex justify-content-center">
            {{ $entradas->links() }}
        </div>
    @else
        <p class="alert alert-danger">No se encontraron entradas.</p>
    @endif
</body>


<script>
    function confirmarEliminar(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta entrada?')) {
            document.getElementById('formEliminar' + id).submit();
        }
    }
    function toggleSort(field) {
        let sort = '{{ request('sort') }}';
        let order = '{{ request('order') }}';

        if (sort === field && order === 'asc') {
            order = 'desc'; // Cambiar a orden descendente
        } else {
            order = 'asc'; // Cambiar a orden ascendente
        }

        // Redirigir a la misma ruta con los nuevos parámetros
        window.location.href = `{{ route('entradas.index') }}?sort=${field}&order=${order}`;    
    }
    
</script>

