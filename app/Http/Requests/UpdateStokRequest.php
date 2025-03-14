<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStokRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "variasi" => 'nullable|array',
            'variasi.*.id' => 'required',
            'variasi.*.size' => 'required|string',
            'variasi.*.arm' => 'nullable|string',
            'variasi.*.color' => 'nullable|string',
            'variasi.*.harga' => 'required|integer',
            'variasi.*.stok' => 'required|integer',
        ];
    }
}
