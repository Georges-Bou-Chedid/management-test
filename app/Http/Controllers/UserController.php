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
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function Fetch(Request $request){
    
        $account = Account::first(); 
        $paginate = $request->input('paginate');
        $users = $account->users()->paginate($paginate);

      return response()->json([
          'message' => 'success',
          'data' => UserResource::collection($users->withPath('management/users/all'))
      ], 200);
      
    }

    public function search(Request $request){

        $validated = $request->validate([
            'term' => 'required',
        ]);

        $account = Account::first();
        $users = $account->users();
        
        $result = $users->where('first_name' , 'like' , '%'.$request->term.'%')->orWhere('last_name' , 'like' , '%'.$request->term.'%');
        if($result->count()==0){ 
            return response()->json([
                'message' => 'failure',
                'error' => "No Users",
            ], 500);
        }      
            if($request->has('verified')){
                if($request->verified != NULL){
                   $result = $result->verified();
                }
            }

            if($request->has('active')){
                if($request->active != NULL){
                   $result = $result->active();
                }
            }

            $final = $result->get();

            return response()->json([
                'message' => 'success',
                'data' => UserResource::collection($final),
            ], 200);
        }
    

    public function store(storeUserRequest $request){
        $account = Account::first();

        $users = new User();

        $users->first_name = $request->first_name;  
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->avatar = $request->avatar;
        $users->is_active = true;
        $users->password= hash::make($request->password);
        
        $users->save();
        $users->Add($account);

        $users->givePermissionTo('create-user','update-user');
     
        Notification::send($users, new UserConfirmationNotification());

        return response()->json([
            'message' => 'success',
            'user' => $users,
        ], 200);
}

    public function confirm($id)
    {
       $user = User::find($id);

       if($user == NULL){
        return response()->json([
            'message' => 'failure',
            'error' => "User Not Found",
        ], 404);
       }

       $user->email_verified_at = date('Y-m-d H:i:s');
       $saved = $user->save();

       if(!$saved){
        return response()->json([
            'message' => 'failure',
            'error' => "User Not Found",
        ], 500);
        }

       return response()->json([
        'message' => 'success',
        'user' =>  UserResource::collection($user),
         ], 200);
    }

    public function update(UpdateUserRequest $request , $id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
        return response()->json([
            'message' => 'failure',
            'error' => 'User Not Found',
        ], 404);
       }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;     
        $user->phone = $request->phone;
        $user->avatar = $request->avatar;
        $user->password= hash::make($request->password);
      
        $user->save();

        Notification::send($user, new UserConfirmationNotification());

        return response()->json([
            'message' => 'success',
            'user' => $user,
        ], 200);
       
    }

    public function delete(DeleteUserRequest $request , $id){
        $account = Account::first();
        $user = User::find($id);

       if($user == NULL || $user->accounts->pluck('id')->contains($account->id) == false){
        return response()->json([
            'message' => 'failure',
            'error' => 'User Not Found',
        ], 404);
       }

        $user->delete();
        return response()->json([
            'message' => 'success',
            'id' => $user->id 
        ], 200);
 
    }
}