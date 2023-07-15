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
            'slug' => 'max:32|unique:contents,slug',
            'edit' => 'max:64',
            'access' => 'max:64',
            'markdown' => 'required|max:65535',
            'onetime' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'The custom URL already been taken',
            'markdown.required' => 'The markdown should not empty',
        ];
    }
}
