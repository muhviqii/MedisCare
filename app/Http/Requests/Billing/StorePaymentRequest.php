<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('processPayment', \App\Models\Invoice::class);
    }

    public function rules(): array
    {
        $invoice = $this->route('invoice');

        return [
            'amount' => [
                'required',
                'numeric',
                'min:1',
                function (string $attribute, mixed $value, \Closure $fail) use ($invoice) {
                    if ((float) $value > (float) $invoice->remainingBalance()) {
                        $fail('Jumlah pembayaran tidak boleh melebihi sisa tagihan.');
                    }
                },
            ],
            'method' => ['required', Rule::in(['cash', 'transfer', 'debit', 'qris', 'insurance'])],
            'reference_number' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.max' => 'Jumlah pembayaran tidak boleh melebihi sisa tagihan.',
        ];
    }
}
