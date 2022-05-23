<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentReuqest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['regex:/^[^0-9]\w*/i', 'unique:departments,name'],
            'users' => 'sometimes|array',
            'users.*' => 'integer'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام سازمان',
            'users' => 'اعضا'
        ];
    }

    public function messages()
    {
        return [
            'regex' => ':attribute نامعتبر است',
            'unique' => ':attribute از قبل وجود دارد'
        ];
    }
}
