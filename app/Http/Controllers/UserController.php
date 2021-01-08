<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();
            return $this->sendResponse(200, $users, 'Resource fetched successfully');
        } catch (Exception $e) {
            // echo($e);
            return $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'phone_number' => 'required',
                'role' => 'required',
            ]);

            if ($validated) {

                $name = $request->input('name');
                $phone_number = $request->input('phone_number');
                $role = $request->input('role');

                $user = User::where('phone_number', $phone_number)->first();

                if (is_null($user)) {
                    $user =  User::create([
                        'name' => $name,
                        'phone_number' => $phone_number,
                        'role' => $role,
                        'password' => Hash::make('1234')
                    ]);

                    return $this->sendResponse(201, $user, 'Resource created successfully');
                } else {
                    return $this->sendResponse(400, '', 'Phone number already taken');
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (isset($user)) {
                return $this->sendResponse(200, $user, 'Resource fetched successfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            return $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $user = User::where('id', $id)->first();

            if (isset($user)) {
                $validated = $request->validate([
                    'name' => 'required',
                    'phone_number' => 'required',
                    'role' => 'required',
                ]);

                if ($validated) {

                    $name = $request->input('name');
                    $phone_number = $request->input('phone_number');
                    $role = $request->input('role');

                    if ($user->phone_number == $phone_number) {
                        $user->name = $name;
                        $user->role = $role;
                    } else {
                        $existingUser = User::where('phone_number', $phone_number)->first();
                        if (is_null($existingUser)) {
                            $user->name = $name;
                            $user->role = $role;
                            $user->phone_number = $phone_number;
                        } else {
                            return $this->sendResponse(400, '', 'Phone number already taken');
                        }
                    }
                    $user->save();
                    return $this->sendResponse(200, $user, 'Resource updated successfully');
                }
            } else {
                return $this->sendResponse(404, null, "Resource not found");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (isset($user)) {
                $user->delete();
                return $this->sendResponse(204, null, "Resource deleted successfully");
            } else {
                return $this->sendResponse(404, null, "Not Found");
            }
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }

    public function changePassword(Request $request){
        try {
            $user = User::where('id', $request->id)->first();
            if(isset($user)){
                $oldpassword = $request->old_password;
                $newpassword = $request->new_password;

                if(Hash::check($oldpassword, $user->password)){
                    $user->password = Hash::make($newpassword);
                    $user->save();
                    return $this->sendResponse(200, $user, "Resource updated successfully");
                }else{
                    return $this->sendResponse(401, null, "Password not correct");
                }
            }else{
                return $this->sendResponse(404, null, "Resource not found");
            }
        } catch (Exception $e) {
            echo($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }
}
