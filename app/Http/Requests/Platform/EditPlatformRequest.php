<?php

namespace App\Http\Requests\Platform;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditPlatformRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //it seems there is no point to use this because global scope are used to retrieve Platforms by logged-in user
        return auth()->user()->can('edit', $this->platform);
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
            'name' => ['required', Rule::unique('platforms')->where(function($q) {
                $q->where('user_id', auth()->id())->where('id', '!=', $this->platform->id);
            })],
            'user_id' => ['required', 'exists:users,id']
        ];
    }
}
