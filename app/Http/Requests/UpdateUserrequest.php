<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $AuthUser = User::find(407);
        

        if($AuthUser->hasPermissionTo('update-user')){
            return true;
        }
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'string|email',
            'phone' => 'string',
            'avatar' => 'string',
            'password' => 'required|min:4| max:7|confirmed',
            'password_confirmation' => 'required|min:4',
          
        ];
    }
}
