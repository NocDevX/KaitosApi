<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetUserRequest extends FormRequest
{
    /**
     * Throw validation errors
     *
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors()->messages(), 422);

        throw new HttpResponseException($response);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user' => 'required|integer'
        ];
    }
}
