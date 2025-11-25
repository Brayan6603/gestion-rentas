<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGastoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'concepto' => ['required', 'string', 'max:200'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_gasto' => ['required', 'date'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'categoria_gasto_id' => ['required', 'integer', 'exists:categoria_gastos,id'],
        ];
    }
}
