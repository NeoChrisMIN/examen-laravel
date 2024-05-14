<!-- resources/views/entradas/crear.blade.php -->
<head>
    <meta charset="UTF-8">
    <title>Detalle</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Crear Nueva Entrada</h2>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form method="POST" action="{{ route('entradas.guardar') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">Usuario:</label>
                <select class="form-control" id="user_id" name="user_id">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoría:</label>
                <select class="form-control" id="categoria_id" name="categoria_id">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}">
            </div>

            <!-- ----------------------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" class="form-control" id="hora" name="hora" value="{{ old('hora') }}">
            </div>

            <div class="form-group">
                <label for="lugar">Lugar:</label>
                <input type="text" class="form-control" id="lugar" name="lugar" value="{{ old('lugar') }}">
            </div>

            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <input type="number" class="form-control" id="prioridad" name="prioridad" value="{{ old('prioridad') }}">
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado') }}">
            </div>

            <button type="submit" class="btn btn-primary">Crear Entrada</button>
        </form>
        <a class="btn btn-primary mt-3" href="{{ route('dashboard') }}">volver</a>
    </div>
</body>

