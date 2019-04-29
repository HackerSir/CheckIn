<?php

namespace App\Http\Requests;

use App\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        /** @var Student $student */
        $student = $this->route('student');

        return [
            'nid'                  => [
                'required',
                'regex:/^[a-z]\d+$/i',
                Rule::unique('students', 'nid')->ignore(optional($student)->nid, 'nid'),
            ],
            'name'                 => 'required',
            'class'                => 'nullable',
            'type'                 => 'nullable',
            'unit_id'              => 'nullable',
            'unit_name'            => 'nullable',
            'dept_id'              => 'nullable',
            'dept_name'            => 'nullable',
            'in_year'              => 'nullable|integer',
            'gender'               => 'nullable',
            'consider_as_freshman' => 'nullable',
        ];
    }
}
