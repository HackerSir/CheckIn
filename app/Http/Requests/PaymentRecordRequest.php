<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User $user */
        $user = $this->user();

        return $user->can('payment-record.manage') || $user->club;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'club_id' => [
                'required',
                'exists:clubs,id',
            ],
            'nid'     => [
                'required',
                'regex:/^[a-z]\d+$/i',
            ],
            'name'    => 'nullable',
            'is_paid' => 'nullable',
            'handler' => 'nullable',
            'note'    => 'nullable',
        ];
    }
}
