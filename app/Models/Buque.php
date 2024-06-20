<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Buque extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_proyecto',
        'tipo_buque',
        'descripcion_proyecto',
        'autonomia_horas',
        'image_path',
        'col_cargo',
        'col_nombre',
        'col_entidad'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sistemasEquipos() {
        return $this->belongsToMany(SistemasEquipos::class, 'buque_sistemas_equipos')
                    ->withPivot('mec', 'titulo', 'diagrama_id','image')
                    ->withTimestamps();
    }
    
    public function colaboradores() {
        return $this->hasMany(Colaborador::class);
    }

    public function misiones() {
        return $this->hasMany(Mision::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        return asset('storage/images/imagenullbuque.png');
    }
}
