<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    //relación uno a muchos
    public function entradas(){
        return $this->hasMany(Entrada::class);
    }
}
