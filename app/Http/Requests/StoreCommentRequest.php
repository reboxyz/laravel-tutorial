<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body'=> 'array|required',
            'user_id' => ['required', 'numeric'],               
            'post_id' => ['required', 'numeric'],               
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Please enter a value for body.',
        ];
    }
}
