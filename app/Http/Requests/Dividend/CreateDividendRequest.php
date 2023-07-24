<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class CreateDividendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'taxes_amount' => 'required|numeric',
            'currency_id' => 'required|exits:currencies,id',
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date'
        ];
    }
}
