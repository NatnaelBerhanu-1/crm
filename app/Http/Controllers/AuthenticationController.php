<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function Login(Request $request){
        try{
            $validated = $request->validate([
                'phone_number'=>'required',
                'password'=>'required'
            ]);
            if($validated){
                $user = User::where('phone_number', $request->phone_number)->first();
                if(isset($user)){
                    if(Hash::check($request->password, $user->password)){
                        return $this->sendResponse(200, $user, "Resource fetched successfully!");
                    }
                }
                return $this->sendResponse(401, null, 'Authentication failed');
            }
        }catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch(Exception $e){
            echo($e);
            return $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    public function changePassword(Request $request) {

    }
}
