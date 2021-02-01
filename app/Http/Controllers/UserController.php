<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\storeUserrequest;
use App\Http\Requests\UpdateUserrequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserConfirmationNotification;
use App\Http\Message\ResponseMessage;

class UserController extends Controller
{
    public function Fetch(){
      $account = Account::first(); 
     $users = $account->users;
      return UserResource::collection($users);
      
    }

    public function search(Request $request){
        $account = Account::first();
        $users = $account->users();
        $term = $account->users;

        $validated = $request->validate([
            'term' => 'required',
        ]);

        if(request('verified')){
          return $users->verified()->get();
        }
        if(request('active')){
            return $users->active()->get();
        }
        if($request->term){ 
            return UserResource::collection($term);
        }
        
    }

    public function create(storeUserrequest $request){
        
        $account = Account::first();

        $users = new User();

        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->avatar = $request->avatar;
        $users->is_active = true;
        $users->password= $request->password;
        $request->password_confirmation;
        
        $users->save();
        $users->Add($account);

        Notification::send($users, new UserConfirmationNotification());
    }

    public function confirm($id)
    {
       $user = User::find($id);
       $user->email_verified_at = date('Y-m-d H:i:s');
       $user->save();
    }

    public function update(UpdateUserrequest $request , $id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
           dd('Failure');
       }

       if($account->verified_at == NULL){

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;     
        $user->phone = $request->phone;
        $user->avatar = $request->avatar;
        $user->password= $request->password;
        $request->password_confirmation;

        $user->save();

        Notification::send($user, new UserConfirmationNotification());
       }
       else{
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;   
        $user->phone = $request->phone;
        $user->avatar = $request->avatar;
        $user->password= $request->password;
        $request->password_confirmation;
        $user->save();
       }
    }

    public function delete($id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
           dd('Failure');
       }
       else{
        $user->delete();
       }

    }
}
