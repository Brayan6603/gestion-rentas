<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaGastoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', 'unique:categoria_gastos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'color' => ['nullable', 'string', 'max:20'],
        ];
    }
}
