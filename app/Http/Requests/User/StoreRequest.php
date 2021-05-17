<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class StoreRequest extends FormRequest
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
            'login'      => ['required', 'string', 'min:3', 'unique:users,login'],
            'firstname'  => ['required', 'alpha', 'max:255', 'min:2'],
            'lastname'   => ['required', 'alpha', 'max:255', 'min:2'],
            'patronymic' => ['required', 'alpha', 'max:255', 'min:4'],
            'password'   => ['required', 'string', 'min:3'],
            'roles'   => [
                'required',
                'array'
            ],
            'roles.*'   => [
                'required',
                'exists:roles,id'
            ],
            'permissions'   => [
                'nullable',
                'array'
            ],
            'permissions.*'   => [
                'required',
                'exists:permissions,id'
            ],
        ];
    }
}
