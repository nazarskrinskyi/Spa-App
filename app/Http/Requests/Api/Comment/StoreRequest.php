<?php

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'username' => 'required|alpha_num',
            'email' => 'required|email',
            'home_page' => 'nullable|url',
            'file' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
            'text' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $allowedTags = ['a', 'code', 'i', 'strong'];
                    $strippedText = strip_tags($value, '<' . implode('><', $allowedTags) . '>');
                    if (trim($strippedText) !== trim($value)) {
                        $fail('The text contains disallowed HTML tags.');
                    }
                    libxml_use_internal_errors(true);
                    $doc = new \DOMDocument();
                    $doc->loadHTML('<' . implode('><', $allowedTags) . '>' . $value);
                    $errors = libxml_get_errors();
                    libxml_clear_errors();
                    if (!empty($errors)) {
                        $fail('The text is not valid XHTML.');
                    }
                },
            ],
        ];
    }


}
