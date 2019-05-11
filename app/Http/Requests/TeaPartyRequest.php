<?php

namespace App\Http\Requests;

use App\TeaParty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeaPartyRequest extends FormRequest
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
        /** @var TeaParty $teaParty */
        $teaParty = $this->route('tea_party');

        return [
            'club_id'  => [
                'required',
                'exists:clubs,id',
                Rule::unique('tea_parties', 'club_id')->ignore(optional($teaParty)->club_id, 'club_id'),
            ],
            'name'     => 'required',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at'   => 'required|date|after_or_equal:start_at',
            'location' => 'required',
            'url'      => 'nullable|url',
        ];
    }
}
