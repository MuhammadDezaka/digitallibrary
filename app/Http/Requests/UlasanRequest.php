<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UlasanRequest extends FormRequest
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
                'user_id' => 'required',
                'buku_id' => 'required',
                'ulasan' => 'required',
                'rating' => 'required'
            ];
        } else if ($this->isMethod('put')) {
            return [
                'id' => 'required|exists:ulasan_buku,id',
                'user_id' => 'required',
                'buku_id' => 'required',
                'ulasan' => 'required',
                'rating' => 'required'
            ];
        } else {
            return new Exception('method is not allowed');
        }
    }
}
