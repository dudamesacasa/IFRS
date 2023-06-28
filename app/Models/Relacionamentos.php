<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relacionamentos extends Model
{
    protected $fillable = [
        'id_documento',
        'usuario_pai',
        'usuario_filho',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'id_documento');
    }
}
