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
      return response()->json([
          'message' => 'success',
          'data' => UserResource::collection($users),
      ], 200);
      
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
            return response()->json([
                'message' => 'success',
                'data' => UserResource::collection($term),
            ], 200);
        }
        
    }

    public function create(storeUserrequest $request){
       try
        {
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

        return response()->json([
            'message' => 'success',
            'user' => $users,
        ], 200);

    }catch(Exception $ex){
        return response()->json([
            'message' => 'failure',
            'error' => 'error message',
        ], 500);
    }
}

    public function confirm($id)
    {
       $user = User::find($id);
       $user->email_verified_at = date('Y-m-d H:i:s');
       $user->save();
       return response()->json([
        'message' => 'success',
        'user' => $user->user_name .' email is now verified',
    ], 200);
    }

    public function update(UpdateUserrequest $request , $id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
        return response()->json([
            'error' => 'User Not Found',
        ], 404);
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

        return response()->json([
            'message' => 'success',
            'user' => $user,
        ], 200);
       }
       else{
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;   
        $user->phone = $request->phone;
        $user->avatar = $request->avatar;
        $user->password= $request->password;
        $request->password_confirmation;
        $user->save();

        return response()->json([
            'message' => 'success',
            'user' => $user,
        ], 200);
       }
    }

    public function delete($id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
        return response()->json([
            'error' => 'User Not Found',
        ], 404);
       }
       else{
        $user->delete();
        return response()->json([
            'message' => 'success',
            'id' => 'User of ID ' . $user->id . ' was Deleted'
        ], 200);
       }

    }
}
