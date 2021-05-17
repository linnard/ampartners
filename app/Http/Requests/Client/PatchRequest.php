<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;


class PatchRequest extends FormRequest
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
            'firstname' => 'nullable|alpha',
            'lastname' => 'nullable|alpha',
            'vacancy_id' => 'nullable|exists:client_vacancies,id',
            'note' => 'nullable|string',
            'is_updated' => 'nullable|in:0,1',
        ];
    }
}
