<?php

namespace App\Http\Requests\Client;

use App\Models\Client\Constants\Status;
use Illuminate\Foundation\Http\FormRequest;
use App\Service\Common\ConstantResolverService;

class CompleteRequest extends FormRequest
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
            'comment' => [
                'required'
            ],
            'complete_at' => [
                'required',
                'date'
            ],
        ];
    }
}
