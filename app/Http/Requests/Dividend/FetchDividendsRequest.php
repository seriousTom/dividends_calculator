<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class FetchDividendsRequest extends FormRequest
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
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'order' => 'nullable|required_with:order_by|in:asc,desc',
            'order_by' => 'nullable|required_with:order|string'
        ];
    }
}
