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
            'customer_name' => ['required', 'string', 'min:3'],
            'phone' => ['required', 'regex:/^(?:\+?20)?0?1[0125]\d{8}$/'],
            'address' => ['required', 'string', 'min:8'],
            'email' => ['nullable', 'email'],
            'notes' => ['nullable', 'string'],
            'utm_source' => ['nullable', 'string'],
            'utm_campaign' => ['nullable', 'string'],
            'utm_adset' => ['nullable', 'string'],
            'utm_ad' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'المنتج',
            'customer_name' => 'اسم العميل',
            'phone' => 'الهاتف',
            'address' => 'العنوان',
            'email' => 'البريد الإلكتروني',
            'notes' => 'ملاحظات',
            'utm_source' => 'مصدر التتبع',
            'utm_campaign' => 'حملة',
            'utm_adset' => 'مجموعة الإعلان',
            'utm_ad' => 'الإعلان',
        ];
    }
}
