<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Alphabet;

class MessageRequest extends FormRequest
{

    public function attributes()
    {
        return [
            'message' => 'پیام',
        ];
    }

    public function messages()
    {
        return [
            'alpha_num' => ':attribute نامعتبر است',
        ];
    }

    public function rules()
    {
        return [
            'message' => [new Alphabet()],
        ];
    }
}
