<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;


class UploadRequest extends FormRequest
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
            'file' => 'required|mimes:jpeg,png,pdf',
           // 'client_id' => 'required|exists:clients,id',
        ];
    }
}
