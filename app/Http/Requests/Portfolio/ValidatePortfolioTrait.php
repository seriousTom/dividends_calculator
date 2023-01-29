<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Platform;

trait ValidatePortfolioTrait
{
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

            if(!auth()->user()->can('select', $plaftorm)) {
                $validator->errors()->add('platform_id', 'Platform does not belongs to user.');
            }
        });
    }
}
