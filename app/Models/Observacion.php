<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $fillable = ['buque_id', 'equipo_id', 'pregunta', 'observacion'];

    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}
    

