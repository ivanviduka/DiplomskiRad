<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'file' => 'required|max:10000|file|filled|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf,doc,docx,xml,html,zip',
            'description' => 'nullable|max:1000',
            'subject_id' => 'required|not_in:0|exists:subjects,id',
        ];
    }
}
