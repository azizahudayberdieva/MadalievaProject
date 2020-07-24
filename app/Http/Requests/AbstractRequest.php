<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize() : bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules() : array;

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator) : void
    {
        throw new ValidationException(
            $validator,
            response()->json($validator->errors(), 422)
        );
    }
}
