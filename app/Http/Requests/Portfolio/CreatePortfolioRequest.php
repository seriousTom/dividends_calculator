<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Platform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePortfolioRequest extends FormRequest
{
    use ValidatePortfolioTrait;

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
            'name' => ['required', Rule::unique('portfolios')->where(function($q) {
                $q->where('user_id', auth()->id());
            })],
            'user_id' => ['required', 'exists:users,id'],
            'platform_id' => ['nullable', 'exists:platforms,id']
        ];
    }
}
