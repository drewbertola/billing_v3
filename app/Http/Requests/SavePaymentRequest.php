<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePaymentRequest extends FormRequest
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
    public static function rules(): array
    {
        return [
            'customerId' => ['required', 'integer'],
            'amount' => ['numeric'],
            'date' => ['date'],
            'method' => ['in:Cash,Check,Card,Transfer'],
            'number' => ['string'],
        ];
    }
}
