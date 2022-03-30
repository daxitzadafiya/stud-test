<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StudentRequest extends FormRequest
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
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'age' => ['required', 'integer'],
            'email' => ['required', 'email'],
            'address' => 'required',
            'dob' => ['required', 'date'],
            'gender' => 'required',
            'course_id' => ['required', 'integer']
        ];
    }
}
