<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Platform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePortfolioRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
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
            'platform_id' => ['required', 'exists:platforms,id']
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(empty($this->platform_id)) {
                return;
            }

            $plaftorm = Platform::find($this->platform_id);

            if(!$plaftorm->belongsToUser(auth()->user()) && !empty($plaftorm->user_id)) {
                $validator->errors()->add('platform_id', 'Platform does not belongs to user.');
            }
        });
    }
}
