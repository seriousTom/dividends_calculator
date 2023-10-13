<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class EditDividendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit', $this->dividend);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'taxes_amount' => ['required', 'numeric'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'company_id' => ['required', 'exists:companies,id'],
            'portfolio_id' => ['required', 'exists:portfolios,id'],
            'date' => ['required', 'date']
        ];
    }

    //todo:check if portfolio belongs to user
}
