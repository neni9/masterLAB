<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactRequest extends Request
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
            'nom'                   => 'required|string|max:50',
            'prenom'                => 'required|string|max:50',
            'email'                 => 'required|email',
            'sujet'                 => 'required|string|max:100',
            'message'               => 'required|string|max:500',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
