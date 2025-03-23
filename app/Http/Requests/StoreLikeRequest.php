<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLikeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => ['nullable', 'exists:posts,id'],
            'comment_id' => ['nullable', 'exists:comments,id'],
            Rule::xor('post_id', 'comment_id'),
        ];
    }
}
