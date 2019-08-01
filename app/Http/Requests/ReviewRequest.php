<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'comment.required'  => '感想を入力してください。',
            'comment.min'          => '文字数が少ないようです。10文字以上で投稿して下さい。',
        ];
    }

}
