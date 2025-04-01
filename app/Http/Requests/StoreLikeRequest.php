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
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $postId = $this->input('post_id');
            $commentId = $this->input('comment_id');

            if (!$postId && !$commentId) {
                $validator->errors()->add('post_id', 'Either post_id or comment_id is required.');
                $validator->errors()->add('comment_id', 'Either post_id or comment_id is required.');
            }

            if ($postId && $commentId) {
                $validator->errors()->add('post_id', 'You cannot like both a post and a comment at the same time.');
                $validator->errors()->add('comment_id', 'You cannot like both a post and a comment at the same time.');
            }
        });
    }
}
