<?php

namespace App\Services\Key;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UniqueKeyService
{
    /**
     * Genera una clave única de longitud 30.
     *
     * @param  string  $modelClass  Modelo donde se valida la unicidad
     * @param  string  $column      Columna a validar
     * @return string
     */
    public static function generate(string $modelClass, string $column = 'identificador'): string
    {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException('La clase debe ser un modelo Eloquent válido.');
        }

        do {
            $key = Str::random(30);
        } while ($modelClass::where($column, $key)->exists());

        return $key;
    }
}