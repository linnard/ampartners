<?php

namespace App\Http\Requests\ClientProperty;

use App\Constants\Client\Status;
use Illuminate\Foundation\Http\FormRequest;
use App\Service\Common\ConstantResolverService;

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
        return [
            'value' => [
                'required'
            ],
            'type_id' => [
                'required',
                'exists:property_types,id'
            ]
        ];
    }
}
