<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TipoConsentimientoUser extends Pivot
{
    protected $table = 'tipo_consentimiento_user';

    protected $fillable = [
        'identificador',
        'user_id',
        'tipo_consentimiento_id',
        'seleccion',
        'estatus',
    ];

    protected $casts = [
        'seleccion' => 'boolean',
        'estatus' => 'boolean',
    ];
}