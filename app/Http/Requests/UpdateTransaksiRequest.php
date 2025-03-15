<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaksiRequest extends FormRequest
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
            'customer' => 'required|string',
            'provinsi_id' => 'required',
            'catatan' => "present",
            'lunas' => "required|boolean",
            'dp' => 'required_if:lunas,0',
            'selesai' => 'required_unless:status,selesai|nullable|date',
            'status' => 'required|in:selesai,diproses,belum diproses',
            'diskon' => 'required|integer',
            'platform' => 'required|in:offline,tokopedia,shopee,tiktok,whatsapp',
            "payment" => 'required|in:cash,transfer',

            'produk' => 'required|array',
            'produk.*.produk_id' => 'required',
            'produk.*.qty' => 'required|integer',

            'files' => 'nullable|array',
            'files.*.file' => 'nullable|file',
        ];
    }
}