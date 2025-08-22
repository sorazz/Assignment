<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
           'status' => 'required|in:0,1',
            'category_id' => 'nullable|exists:category,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
     public function messages(): array
    {
        return [
            'title.required' => 'The company name is required.',

            'title.max' => 'The company name may not be greater than 255 characters.',
            'description.string' => 'The description must be a valid string.',
            'category_id.exists' => 'The selected category does not exist.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'image.max' => 'The image size may not exceed 2MB.',
        ];
    }
}
