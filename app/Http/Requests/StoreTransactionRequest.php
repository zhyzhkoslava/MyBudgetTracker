<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'date|required',
            'type' => 'required|string|in:income,expense',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'integer|required',
            'description' => 'string|min:3|max:255|required',
        ];
    }
}
