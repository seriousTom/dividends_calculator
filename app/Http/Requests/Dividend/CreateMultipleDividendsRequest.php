<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class CreateMultipleDividendsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit', $this->portfolio);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'dividends' => 'required',
            'dividends.*.company_id' => 'required|exists:companies,id',
            'dividends.*.amount' => 'required|numeric',
            'dividends.*.taxes_amount' => 'nullable|numeric',
            'dividends.*.currency_id' => 'required|exists:currencies,id',
            'dividends.*.date' => 'required|date',
        ];
    }
}
