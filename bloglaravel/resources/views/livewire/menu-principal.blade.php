<div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
        
    <div class="container centrar">

        @if (auth()->check())
            @if (auth()->user()->rol === 'admin')
                <div>
                    Tu rol es: admin
                </div>
            @else
                <div>
                    Tu rol es: user
                </div>
            @endif
        @endif

        <form id="logoutForm" method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit" @click.prevent="$refs.logoutForm.submit();">
                {{ __('Log Out') }}
            </button>
        </form>

        <div class="container cuerpo text-center">
        <p>
        <h2>Base de Datos</h2>
        </p>
        </div>
        <ul>
        <h4>Entradas</h4>
        <li><a href="{{ route('entradas.index') }}">Listar entradas</a></li>
        <li><a href="{{ route('entradas.crear') }}">Añadir entrada</a></li>
        </ul>
    </div>
</div>
