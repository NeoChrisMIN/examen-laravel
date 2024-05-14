<!-- detalle.blade.php -->

<head>
    <meta charset="UTF-8">
    <title>Detalle</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ $entrada->titulo }}</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>ID:</strong> {{ $entrada->id }}</li>
                    <li class="list-group-item"><strong>Usuario:</strong> {{ $entrada->user->name }}</li>
                    <li class="list-group-item"><strong>Categoría:</strong> {{ $entrada->categoria->nombre }}</li>
                    <li class="list-group-item"><strong>Descripción:</strong> {{ $entrada->descripcion }}</li>
                    <li class="list-group-item"><strong>Fecha:</strong> {{ $entrada->fecha }}</li>
                    <li class="list-group-item"><strong>Imagen:</strong> <img src="{{ asset('storage/' . $entrada->imagen) }}" alt="Imagen de la entrada" class="img-fluid"></li>
                    <li class="list-group-item"><strong>Hora:</strong> {{ $entrada->hora }}</li>
                    <li class="list-group-item"><strong>Lugar:</strong> {{ $entrada->lugar }}</li>
                    <li class="list-group-item"><strong>Prioridad:</strong> {{ $entrada->prioridad }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ $entrada->estado }}</li>
                </ul>
                <a href="{{ route('entradas.index') }}" class="btn btn-primary mt-3">Volver</a>
            </div>
        </div>
    </div>
    
</body>