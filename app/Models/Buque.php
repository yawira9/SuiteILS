<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buque extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_proyecto',
        'tipo_buque',
        'descripcion_proyecto',
        'autonomia_horas',
        'image_path',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
