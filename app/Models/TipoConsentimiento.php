<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConsentimiento extends Model
{
    protected $table = "tipos_consentimientos";
    protected $fillable = ['consentimiento'];

/*     public function users()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'tipo_consentimiento_user'
        )->withPivot(['seleccion', 'estatus'])
         ->withTimestamps();
    } */
    public function users()
{
    return $this->belongsToMany(
        User::class,
        'tipo_consentimiento_user',
        'tipo_consentimiento_id',
        'user_id'
    )->withTimestamps();
}
}
