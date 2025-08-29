<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'min:3', 'max:255'],
            'phone' => ['required', 'regex:/^(?:\+?20)?0?1[0125]\d{8}$/'],
            'address' => ['required', 'string', 'min:10'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],
            'utm_adset' => ['nullable', 'string', 'max:255'],
            'utm_ad' => ['nullable', 'string', 'max:255'],
            'website' => ['prohibited'], // P10 Honeypot
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'المنتج',
            'customer_name' => 'الاسم الكامل',
            'phone' => 'رقم الهاتف',
            'address' => 'العنوان',
            'email' => 'البريد الإلكتروني',
            'notes' => 'ملاحظات',
        ];
    }
}
