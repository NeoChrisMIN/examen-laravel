<head>
    <meta charset="UTF-8">
    <title>Base de Datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
</head>

<body>
    <!-- Formulario de edición con campo de imagen -->
<div class="container">
    <h2>Editar Entrada</h2>
    <form method="POST" action="{{ route('entradas.update', $entrada->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select class="form-control" id="categoria_id" name="categoria_id">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $entrada->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $entrada->titulo }}">
        </div>

        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen">
            <img src="{{ asset('storage/' . $entrada->imagen) }}" alt="Imagen de la entrada" class="img-fluid mt-2" style="max-width: 200px;">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ $entrada->descripcion }}</textarea>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $entrada->fecha }}">
        </div>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" value="{{ $entrada->hora }}">
        </div>

        <div class="form-group">
            <label for="lugar">Lugar:</label>
            <input type="text" class="form-control" id="lugar" name="lugar" value="{{ $entrada->lugar }}">
        </div>

        <div class="form-group">
            <label for="prioridad">Prioridad:</label>
            <input type="number" class="form-control" id="prioridad" name="prioridad" value="{{ $entrada->prioridad }}">
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="{{ $entrada->estado }}">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
