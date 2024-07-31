<?php

namespace App\Http\Requests;

use App\Rules\IntergerOnlyRule;
use Hamcrest\Core\Every;
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
            'body' => ['string', 'required'],
            'user_id' => [
                'array',
                'required',
                new IntergerOnlyRule
                // function ($attribute, $value, $fail) {
                //     $intergerOnly = collect($value)->every(fn ($element) => is_int($element));

                //     if (!$intergerOnly) {
                //         $fail($attribute . ' can only be integer');
                //     }
                // }
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.string' => 'Invalid title. String format required.',
            'body.required' => 'Invalid body. Body is required.',
            'user_id.array' => 'Invalid user_id. User_id must be array.',
        ];
    }
}
