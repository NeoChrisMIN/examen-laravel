<?php

namespace App\Livewire;

use Livewire\Component;

class MenuPrincipal extends Component
{
    public function render()
    {
        return view('livewire.menu-principal');
    }

    /*
    public function redirectToListar()
    {
        return redirect()->route('entradas.index');
    }

    public function redirectToCrear()
    {
        return redirect()->route('entradas.crear');
    }*/
}
