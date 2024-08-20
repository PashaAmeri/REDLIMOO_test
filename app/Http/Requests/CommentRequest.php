<?php

namespace App\Http\Requests;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'post_id' => ['required', 'numeric', 'exists:' . Post::class . ',id'],
            'parent_id' => ['nullable', 'numeric', 'exists:' . Comment::class . ',id'],
            'content' => ['required', 'string', 'max:255'],
        ];
    }
}
