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
            "email" => 'required|email|string',
            "password" => 'required|string|confirmed|min:6',
            "nama" => "string|required",
            "prodi_id" => "integer|required",
            "ipk" => "numeric|required",
            "tahun_masuk" => "date_format:Y|required",
            "tahun_lulus" => "date_format:Y|required",
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Isian kolom username tidak boleh kosong',
            'username.string' => 'Isian kolom username harus berupa teks',
            'username.unique' => 'Isian kolom username sudah terdaftar',
            'email.required' => 'Isian kolom email tidak boleh kosong',
            'email.string' => 'Isian kolom email harus berupa teks',
            'email.email' => 'Isian kolom email harus sesuai dengan format email',
            'password.required' => 'Isian kolom password tidak boleh kosong',
            'password.string' => 'Isian kolom password harus berupa teks',
            'password.confirmed' => 'Isian kolom password tidak sama',
            'password.min' => 'Isian kolom password kurang dari 6 karakter',
            'nama.string' => 'Isian dari kolom nama harus berupa teks',
            'nama.required' => 'Isian dari kolom nama tidak boleh kosong',
            'prodi_id.required' => 'Isian dari kolom prodi tidak boleh kosong',
            'prodi_id.integer' => 'Isian dari kolom prodi harus berupa angka',
            'ipk.numeric' => 'Isian dari kolom ipk harus berupa bilangan',
            'ipk.required' => 'Isian dari kolom ipk tidak boleh kosong',
            'tahun_masuk.date_format' => 'Isian dari kolom tahun masuk harus berupa tahun',
            'tahun_masuk.required' => 'Isian dari kolom tahun masuk tidak boleh kosong',
            'tahun_lulus.date_format' => 'Isian dari kolom tahun lulus harus berupa tahun',
            'tahun_lulus.required' => 'Isian dari kolom tahun lulus tidak boleh kosong',
        ];
    }
}
