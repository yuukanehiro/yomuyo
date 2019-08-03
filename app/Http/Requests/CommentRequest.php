<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'res'     => 'required|max:10'
        ];
    }

    public function messages()
    {
        return [
            'res.required'  => 'ごめんなさい。コメントを入力してください。空欄のようです。',
            'res.max'       => 'ごめんなさい。文字数が少ないようです。10文字以上で入力をお願いします。'
        ];
    }


}
