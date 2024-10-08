<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\UniquePhone;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:11|regex:/(09)[0-9]{9}/|unique:' . User::class . ',phone',
            'email' => 'required|string|email|max:255|unique:' . User::class . ',email',
            'bio' => 'nullable|string|max:1024',
            'otp' => 'required|numeric|digits:6'
        ];
    }
}
