<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class deleteUserrequest extends FormRequest
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
            //
        ];
    }
}