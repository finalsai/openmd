<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'min:2|max:32|alpha_num:ascii|unique:contents,slug|nullable',
            'edit' => 'min:1|max:64|nullable',
            'access' => 'min:1|max:64|nullable',
            'markdown' => 'required|max:65535',
            'onetime' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'The custom URL already been taken',
            'slug.alpha_num' => 'The custom URL only allows letters and numbers',
            'markdown.required' => 'The markdown should not empty',
        ];
    }
}
