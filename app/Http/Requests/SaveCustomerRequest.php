<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCustomerRequest extends FormRequest
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
            'name' => ['required', 'max:64'],
            'bAddress1' => ['max:64'],
            'bAddress2' => ['max:64'],
            'bCity' => ['max:32'],
            'bState' => ['max:32'],
            'bZip' => ['max:16'],
            'sAddress1' => ['max:64'],
            'sAddress2' => ['max:64'],
            'sCity' => ['max:32'],
            'sState' => ['max:32'],
            'sZip' => ['max:16'],
            'phoneMain' => ['max:16'],
            'fax' => ['max:16'],
            'billingContact' => ['max:32'],
            'billingEmail' => ['max:64'],
            'billingPhone' => ['max:16'],
            'primaryContact' => ['max:32'],
            'primaryEmail' => ['max:64'],
            'primaryPhone' => ['required', 'max:16'],
            'taxRate' => ['min:0', 'max:100'],
            'archive' => ['in:Y,N'],
        ];
    }
}
