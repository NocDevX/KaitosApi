<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'name' => 'required_without:email|string',
            'email' => 'required_without:name|string',
            'password' => 'required|string'
        ];
    }
}
