<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RifaOrden extends Model
{
    protected $table = 'rifa_ordenes';
    protected $primaryKey = 'orden_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;
    const CREATED_AT = 'fyh_creacion';
    const UPDATED_AT = 'fyh_actualizacion';

    protected $fillable = [
        'rifa_id',
        'user_id',
        'comprador_nombre',
        'comprador_telefono',
        'comprador_email',
        'total_boletos',
        'monto_total',
        'metodo_pago',
        'referencia_pago',
        'comprobante_url',
        'estatus',
        'fyh_pago',
    ];

    protected $casts = [
        'total_boletos' => 'integer',
        'monto_total'   => 'decimal:2',
        'fyh_pago'      => 'datetime',
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

    public function boletos()
    {
        return $this->hasMany(RifaBoleto::class, 'orden_id', 'orden_id');
    }

    /* ================== Helpers ================== */
    public function estaPagada(): bool
    {
        return $this->estatus === 'pagado';
    }
}
