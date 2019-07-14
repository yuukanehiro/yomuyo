<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:50'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '作者名か、本のタイトルを入力してください。',
            'name.max'     => '文字数が多いようです。短くキーワードを入力してください。',
        ];
    }


}

