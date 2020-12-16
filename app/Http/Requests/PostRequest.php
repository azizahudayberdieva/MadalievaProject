<?php

namespace App\Http\Requests;

use App\Models\Post;

class PostRequest extends AbstractRequest
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

        if (in_array($this->getMethod(), ['PUT', 'PATCH'])) {
            $rules['attachment'] = ['nullable', 'mimes:docx,pdf,mp4,flv', 'max:512000'];
        }

        return $rules;
    }
}
