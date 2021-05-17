<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;


class UpdateRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'login'      => ['required', 'string', 'min:3', 'unique:users,login,'.$user->id],
            'firstname'  => ['required', 'alpha', 'max:255', 'min:2'],
            'lastname'   => ['required', 'alpha', 'max:255', 'min:2'],
            'patronymic' => ['required', 'alpha', 'max:255', 'min:4'],
            'password'   => ['nullable', 'string', 'min:3'],

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
