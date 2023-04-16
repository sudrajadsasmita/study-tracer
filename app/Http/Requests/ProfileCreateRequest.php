<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProfileCreateRequest extends FormRequest
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
            "nama" => "string|required",
            "nim" => "string|required",
            "prodi_id" => "integer|required",
            "ipk" => "numeric|required",
            "tahun_masuk" => "date_format:Y|required",
            "tahun_lulus" => "date_format:Y|required",
            "status_bekerja" => "string|in:YA,TIDAK|nullable",
            "saran_prodi" => "string|nullable",
            "alamat_perusahaan" => "string|nullable",
            "jabatan" => "string|nullable",
            "lama_bekerja" => "integer|nullable",
            "gaji" => "integer|nullable",
            "deskripsi" => "string|nullable",
            "photo" => "file|max:10240|nullable",

        ];
    }

    public function messages(): array
    {
        return [
            'nama.string' => 'Isian dari kolom nama harus berupa teks',
            'nama.required' => 'Isian dari kolom nama tidak boleh kosong',
            'nim.string' => 'Isian dari kolom nama harus berupa teks',
            'nim.required' => 'Isian dari kolom nama tidak boleh kosong',
            'prodi_id.required' => 'Isian dari kolom prodi tidak boleh kosong',
            'prodi_id.integer' => 'Isian dari kolom prodi harus berupa angka',
            'ipk.numeric' => 'Isian dari kolom ipk harus berupa bilangan',
            'ipk.required' => 'Isian dari kolom ipk tidak boleh kosong',
            'tahun_masuk.date_format' => 'Isian dari kolom tahun masuk harus berupa tahun',
            'tahun_masuk.required' => 'Isian dari kolom tahun masuk tidak boleh kosong',
            'tahun_lulus.date_format' => 'Isian dari kolom tahun lulus harus berupa tahun',
            'tahun_lulus.required' => 'Isian dari kolom tahun lulus tidak boleh kosong',
            'saran_prodi.string' => 'Isian dari kolom saran prodi harus berupa teks',
            'alamat_perusahaan.string' => 'Isian dari kolom alamat perusahaan harus berupa teks',
            'jabatan.string' => 'Isian dari kolom jabatan harus berupa teks',
            'lama_bekerja.string' => 'Isian dari kolom lama bekerja harus berupa teks',
            'gaji.integer' => 'Isian dari kolom gaji harus berupa bilangan',
            'deskripsi.string' => 'Isian dari kolom deskripsi harus berupa teks',
            "photo.file" => "Inputan pada kolom photo harus berupa file",
            "photo.required" => "Inputan pada kolom photo tidak boleh kosong",
            "photo.max" => "Inputan pada kolom image tidak boleh lebih dari 10MB",
        ];
    }
}
