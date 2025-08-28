<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RifaBoleto extends Model
{
    protected $table = 'rifa_boletos';
    protected $primaryKey = 'rifa_boleto_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;
    const CREATED_AT = 'fyh_creacion';
    const UPDATED_AT = 'fyh_actualizacion';

    protected $fillable = [
        'rifa_id',
        'numero',
        'estado',            // disponible | apartado | vendido | anulado
        'user_id',
        'orden_id',
        'reservado_hasta',
    ];

    protected $casts = [
        'numero' => 'integer',
        'reservado_hasta' => 'datetime',
    ];

    /* ================== Relaciones ================== */
    public function rifa()
    {
        return $this->belongsTo(Rifa::class, 'rifa_id', 'rifa_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orden()
    {
        return $this->belongsTo(RifaOrden::class, 'orden_id', 'orden_id');
    }

    /* ================== Scopes ================== */
    public function scopeDisponibles($q)
    {
        return $q->where('estado', 'disponible');
    }

    public function scopeApartadosVencidos($q)
    {
        return $q->where('estado', 'apartado')
                 ->whereNotNull('reservado_hasta')
                 ->where('reservado_hasta', '<', now())
                 ->whereNull('orden_id');
    }

    /* ================== Helpers ================== */
    public function estaDisponible(): bool
    {
        return $this->estado === 'disponible';
    }

    public function estaApartadoYVencido(): bool
    {
        return $this->estado === 'apartado'
            && $this->reservado_hasta !== null
            && $this->reservado_hasta->lt(now())
            && $this->orden_id === null;
    }
}
