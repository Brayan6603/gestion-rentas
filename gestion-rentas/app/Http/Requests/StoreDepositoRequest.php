<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_deposito' => ['required', 'date'],
            'estado' => ['required', 'string', 'in:activo,devuelto,parcial'],
            'inquilino_id' => ['required', 'integer', 'exists:inquilinos,id'],
            'monto_devuelto' => ['nullable', 'numeric', 'min:0'],
            'fecha_devolucion' => ['nullable', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'concepto_retencion' => ['nullable', 'string', 'max:300'],
        ];
    }
}
