<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'include_phone'             => 'nullable|required_without_all:include_email,include_facebook,include_line',
            'include_email'             => 'nullable|required_without_all:include_phone,include_facebook,include_line',
            'include_facebook'          => 'nullable|required_without_all:include_phone,include_email,include_line',
            'include_line'              => 'nullable|required_without_all:include_phone,include_email,include_facebook',
            'message'                   => 'nullable|max:255',
            'answer_of_custom_question' => 'nullable|max:255',
            'join_club_intention'       => 'required|in:0,1,2',
            'join_tea_party_intention'  => 'required|in:0,1,2',
        ];
    }
}
