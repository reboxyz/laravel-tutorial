<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'string|required',
            'body' => ['array', 'required'],
            'user_ids' => [
                'array',
                'required',
                new IntegerArray()
            
                /*
                // closure params: $attribute is field name, $value is the value, $fail is callback function
                function($attribute, $value, $fail) {
                    // validate that User_ids are only integer values
                    $integerOnly = collect($value)->every(fn ($element) => is_int($element));
                    //dump($integerOnly);

                    if (! $integerOnly) {
                        $fail($attribute . ' can only be integers.');
                    }
                }
                */
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Title must be a string.',
            'title.required' => 'Please enter a value for title.',
            'body.required' => 'Please enter a value for body.'
        ];
    }
}
