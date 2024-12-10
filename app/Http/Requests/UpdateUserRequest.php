<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $user_id = $this->route('user'); // Получаем ID пользователя из роута
        return ['name'     => 'sometimes|string|max:255',
                'email'    => 'sometimes|email|unique:users,email,' . $user_id,
                'password' => 'sometimes|string|min:6',
                'ip'       => 'nullable|string|max:15',
                'comment'  => 'nullable|string',];
    }
}
