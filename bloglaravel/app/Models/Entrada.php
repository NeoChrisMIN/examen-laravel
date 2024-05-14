<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    /*//relación uno a uno polimorfica
    public function image(){
        return $this->morphOne(Image::class,"imageable");
    }*/

    // para que permita modificar estos datos
    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'titulo',
        'imagen',
        'descripcion',
        'fecha',
        'hora', 
        'prioridad', 
        'lugar', 
        'estado',
    ];
    
}
