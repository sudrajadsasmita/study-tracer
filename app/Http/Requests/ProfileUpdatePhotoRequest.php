<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProfileUpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => "Validation Error...",
                'data'    => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "photo" => "file|max:10240|nullable",
        ];
    }
    public function messages(): array
    {
        return [
            "photo.file" => "Inputan pada kolom photo harus berupa file",
            "photo.required" => "Inputan pada kolom photo tidak boleh kosong",
            "photo.max" => "Inputan pada kolom image tidak boleh lebih dari 10MB",
        ];
    }
}
