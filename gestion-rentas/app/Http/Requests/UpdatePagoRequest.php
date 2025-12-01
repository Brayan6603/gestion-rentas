<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePagoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_pago' => ['nullable', 'date'],
            'mes_correspondiente' => ['required', 'date'],
            'estado' => ['required', 'string', 'in:pendiente,pagado,parcial'],
            'inquilino_id' => ['required', 'integer', 'exists:inquilinos,id'],
        ];
    }
}
