<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    protected $table = 'invitaciones';

    protected $fillable = [
        'user_id',
        'evento_id',
        'qr_token',
        'asistencia_confirmada',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evento()
    {
        return $this->belongsTo(Event::class);
    }

    public function confirmaciones()
    {
        return $this->hasMany(\App\Models\Confirmacion::class);
    }

    public function ultimaConfirmacion()
{
    return $this->hasOne(\App\Models\Confirmacion::class, 'nombre', 'user.name')->latestOfMany();
}

}
