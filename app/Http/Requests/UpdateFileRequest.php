<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
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
            'user_file_name' => ['required', 'regex:/^[a-ŽA-Ž0-9._ -]+$/', 'max:70'],
            'description' => 'nullable|max:1000',
            'subject_id' => 'required|not_in:0|exists:subjects,id',
        ];
    }
}
