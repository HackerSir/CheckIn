<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactInformationRequest extends FormRequest
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
            'student_nid' => 'required|exists:students,nid',
            'phone'       => [
                'nullable',
                'required_without_all:email,facebook,line',
                'max:255',
                'regex:/^[\d\-+()#\s]{8,}$/',
            ],
            'email'       => 'nullable|required_without_all:phone,facebook,line|max:255|email',
            'facebook'    => 'nullable|required_without_all:phone,email,line|max:255',
            'line'        => [
                'nullable',
                'required_without_all:phone,email,facebook',
                'max:255',
                'regex:/^[\w\-\.]+$/',
            ],
            'message'     => 'nullable|max:255',
        ];
    }
}
