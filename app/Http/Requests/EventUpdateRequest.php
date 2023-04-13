<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class EventUpdateRequest extends FormRequest
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
            "user_id" => "integer|required",
            "nama" => "string|required",
            "url" => "string|required",
            "image" => "file|max:10240|nullable",
            "type" => "string|in:LOKER,MAGANG,BEASISWA|required"
        ];
    }

    public function messages(): array
    {
        return [
            "user_id.integer" => "Inputan pada kolom user id harus berupa angka",
            "user_id.required" => "Inputan pada kolom user id tidak boleh kosong",
            "nama.string" => "Inputan pada kolom nama harus berupa huruf",
            "nama.required" => "Inputan pada kolom nama tidak boleh kosong",
            "url.string" => "Inputan pada kolom url harus berupa huruf",
            "url.required" => "Inputan pada kolom url tidak boleh kosong",
            "image.file" => "Inputan pada kolom image harus berupa file",
            "image.required" => "Inputan pada kolom image tidak boleh kosong",
            "image.max" => "Inputan pada kolom image tidak boleh lebih dari 10MB",
            "type.string" => "Inputan pada kolom type harus berupa huruf",
            "type.required" => "Inputan pada kolom type tidak boleh kosong",
            "type.in" => "Inputan pada kolom harus loker, magang atau beasiswa",
        ];
    }
}
