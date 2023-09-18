<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
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
        $id = $this->request->get('id');
        $validation = [
            'email' => 'required|email:rfc,dns|max:100|unique:users,email' . ($id ? ",$id" : ''),
            'first_name' => ['required', 'max:50'],
            'user_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'birthday' => ['required', "before:" . Carbon::now()->subYear(18)->toString()],
            "avatar" => [
                'image',
                'mimes:jpeg,png,jpg',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:3072',
            ],
            'province' => ['required'],
            'district' => ['required'],
            'commune' => ['required'],
        ];
        if ($id == null) {
            $validation['password'] = ["required"];
        }
        return $validation;
    }
}
