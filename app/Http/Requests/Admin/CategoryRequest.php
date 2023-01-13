<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->isMethod('post')) {
            $rules = [
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
                'name' => 'required|unique:categories'
            ];
        } elseif (request()->isMethod('PUT')) {
            $rules = [
                'name' => 'required'
            ];
        }
        return $rules;
    }
}
