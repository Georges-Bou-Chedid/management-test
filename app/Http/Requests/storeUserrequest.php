<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class storeUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $AuthUser = User::find(1);
        

        if($AuthUser->hasPermissionTo('create-user')){
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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required| min:4| max:7|confirmed',
            'password_confirmation' => 'required|min:4',
            'avatar' => 'string',
        ];
    }

   /* public function withValidator($validator)
    {
        // checks user current password
        // before making changes
        $validator->after(function ($validator) {
            if ( !Hash::check($this->password_confirmation , $this->password) ) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });
        return;
    }*/
}
