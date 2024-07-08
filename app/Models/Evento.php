<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
    'fecha_inicio',
    'fecha_fin',
    'titulo',
    'tipo_evento_id',
    ];


    public function tipoEvento(){
        return $this->belongsTo(TipoEvento::class);
    }
}
