<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->request->get("id");
        return [
            'name' => ['required', 'max:255'],
            'stock' => ["required", "numeric", 'min:0', 'max:10000'],
            "expired_at" => ["after:" . Carbon::now()],
            "sku" => 'required|min:10|max:20|regex:/\w/|unique:products,sku' . ($id ? ",$id" : ''),
            "avatar" => [
                'image',
                'mimes:jpeg,png,jpg',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:3072',
            ],
            "category_id" => ["required", 'exists:product_category,id'],
        ];
    }
}
