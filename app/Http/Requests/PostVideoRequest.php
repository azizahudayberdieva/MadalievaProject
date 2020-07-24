<?php

namespace App\Http\Requests;

use App\Models\Post;

class PostVideoRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = Post::RULES;

        $rules['file'] = 'required|mimes:mp4,flv|max:512000';

        return $rules;
    }
}
