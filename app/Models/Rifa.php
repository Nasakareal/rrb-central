<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
    protected $table = 'rifas';
    protected $primaryKey = 'rifa_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;
    const CREATED_AT = 'fyh_creacion';
    const UPDATED_AT = 'fyh_actualizacion';

    protected $fillable = [
        'titulo',
        'descripcion',
        'causa',
        'imagen',
        'precio_boleto',
        'total_boletos',
        'numeracion_desde',
        'numeracion_hasta',
        'max_boletos_por_usuario',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'ganador_boleto_id',
        'ganador_user_id',
    ];

    protected $casts = [
        'precio_boleto' => 'decimal:2',
        'total_boletos' => 'integer',
        'numeracion_desde' => 'integer',
        'numeracion_hasta' => 'integer',
        'max_boletos_por_usuario' => 'integer',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /* ================== Relaciones ================== */
    public function boletos()
    {
        return $this->hasMany(RifaBoleto::class, 'rifa_id', 'rifa_id');
    }

    public function boletosDisponibles()
    {
        return $this->boletos()->where('estado', 'disponible');
    }

    public function boletosApartados()
    {
        return $this->boletos()->where('estado', 'apartado');
    }

    public function boletosVendidos()
    {
        return $this->boletos()->where('estado', 'vendido');
    }

    public function ordenes()
    {
        return $this->hasMany(RifaOrden::class, 'rifa_id', 'rifa_id');
    }

    public function ganadorBoleto()
    {
        return $this->belongsTo(RifaBoleto::class, 'ganador_boleto_id', 'rifa_boleto_id');
    }

    public function ganadorUser()
    {
        return $this->belongsTo(User::class, 'ganador_user_id', 'id');
    }

    /* ================== Scopes útiles ================== */
    public function scopeActivas($q)
    {
        return $q->where('estado', 'activa');
    }

    public function scopeVigentes($q)
    {
        return $q->where(function ($qq) {
            $qq->whereNull('fecha_inicio')->orWhere('fecha_inicio', '<=', now());
        })->where(function ($qq) {
            $qq->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', now());
        });
    }

    /* ================== Helpers ================== */
    public function getBoletosVendidosCountAttribute()
    {
        return $this->boletosVendidos()->count();
    }

    public function getBoletosDisponiblesCountAttribute()
    {
        return $this->boletosDisponibles()->count();
    }

    public function getAvanceVentaPorcAttribute()
    {
        if ($this->total_boletos <= 0) return 0;
        return round(($this->boletosVendidos()->count() * 100) / $this->total_boletos, 2);
    }
}
