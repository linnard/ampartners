<?php

namespace App\Http\Requests\User;

use App\Constants\User\Status;
use App\Service\Common\ConstantResolverService;
use Illuminate\Foundation\Http\FormRequest;


class UpdateStatusRequest extends FormRequest
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
            'status' => [
                'required',
                sprintf("in:%s",
                    (new ConstantResolverService())
                        ->resolve(Status::class)
                        ->collect()
                        ->implode(',')
                )
            ],
        ];
    }
}
