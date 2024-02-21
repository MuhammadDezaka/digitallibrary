<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class KategoriBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')) {
            return [
                'nama' => 'required',
            ];
        } else if ($this->isMethod('put')) {
            return [
                'id' => 'required|exists:kategori_buku,id',
                'nama' => 'required',
            ];
        } else {
            return new Exception('method is not allowed');
        }
    }
}
