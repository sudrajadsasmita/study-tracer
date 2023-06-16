<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

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

    public function rules(): array
    {
        return [
            "username" => "required|string|unique:users,username",
            "password" => 'required|string|confirmed|min:6',
            "prodi_id" => "integer|required",
            "email" => 'required|email|string',
            "nama" => "string|nullable",
            "ipk" => "numeric|nullable",
            "tahun_masuk" => "date_format:Y|nullable",
            "tahun_lulus" => "date_format:Y|nullable",
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Isian kolom username tidak boleh kosong',
            'username.string' => 'Isian kolom username harus berupa teks',
            'username.unique' => 'Isian kolom username sudah terdaftar',
            'password.required' => 'Isian kolom password tidak boleh kosong',
            'password.string' => 'Isian kolom password harus berupa teks',
            'password.confirmed' => 'Isian kolom password tidak sama',
            'password.min' => 'Isian kolom password kurang dari 6 karakter',
            'prodi_id.required' => 'Isian dari kolom prodi tidak boleh kosong',
            'prodi_id.integer' => 'Isian dari kolom prodi harus berupa angka',
            'email.required' => 'Isian kolom email tidak boleh kosong',
            'email.string' => 'Isian kolom email harus berupa teks',
            'email.email' => 'Isian kolom email harus sesuai dengan format email',
            'nama.string' => 'Isian dari kolom nama harus berupa teks',
            'ipk.numeric' => 'Isian dari kolom ipk harus berupa bilangan',
            'tahun_masuk.date_format' => 'Isian dari kolom tahun masuk harus berupa tahun',
            'tahun_lulus.date_format' => 'Isian dari kolom tahun lulus harus berupa tahun',
        ];
    }
}
