<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{

    public function messages()
    {
        return [
            'string' => ':attribute نامعتبر است',
            'required' => ':attribute الزامیست',
            'numeric' => ':attribute نامعتبر است',
            'boolean' => ':attribute نامعتبر است',
            'in' => ':attribute نامعتبر است',
        ];
    }

    public function attributes()
    {
        return [
            'text' => 'متن',
            'subject' => 'موضوع',
            'status' => 'وضعیت',
            'cc' => 'رونوشت',
            'bcc' => 'رونوشت محرمانه',
            'inboxId' => 'صندوق دریافتی',
            'priority' => 'اولویت',
            'attached' => 'ضمیمه'
        ];
    }

    public function rules()
    {
        return [
            'text' => 'string|required',
            'subject' => 'string|required',
            'status' => 'numeric',
            'cc' => 'nullable|array',
            'bcc' => 'nullable|array',
            'inboxId' => 'nullable|numeric',
            'priority' => 'in:none,low,medium,hight',
            'attached' => 'nullable|file|mimes:doc,docx,pdf,png,jpg',
        ];
    }
}
