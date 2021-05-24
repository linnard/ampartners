<?php

namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => [
                'required',
                'array'
            ],
            'title.*' => [
                'required',
                'string',
            ],
            'changes' => [
                'nullable',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'sort' => [
                'min:0',
                'integer',
            ],
            'content' => [
                'required',
                'array'
            ],
            'content.*' => [
                'required',
                'string',
            ],
            'is_urgently' => [
                'nullable'
            ],
            'is_individual_coordination' => [
                'nullable'
            ],
            'age_from' => [
                'integer'
            ],
            'age_to' => [
                'integer'
            ],
            'status' => [
                'required',
                'integer'
            ],
            'filter_items' => [
                'sometimes',
            ],
            'filter_items.*' => [
                'nullable',
                'exists:filter_items,id',
            ]


        ];
    }

}
