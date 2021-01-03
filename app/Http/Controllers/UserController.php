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
            $users = User::paginate();
            return $this->sendResponse(200, $users, 'Resource fetched successfully');
        } catch (Exception $e) {
            // echo($e);
            return $this->sendResponse(500,null, 'Something went wrong');
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
        $validated = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'role' => 'required',
        ]);

        if($validated){

            $name = $request->input('name');
            $phone_number = $request->input('phone_number');
            $role = $request->input('role');

            $user = User::where('phone_number', $phone_number)->first();

            if(is_null($user)){
                $user =  User::create([
                    'name'=>$name,
                    'phone_number'=>$phone_number,
                    'role'=>$role,
                    'password'=>Hash::make('1234')
                ]);

                return $this->sendResponse(201, $user, 'Resource created successfully');
            }else{
                return $this->sendResponse(400, '', 'Phone number already taken');
            }
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
        try{
            $user = User::where('id', $id)->first();
            if(isset($user)){
                return $this->sendResponse(200, $user, 'Resource fetched successfully');
            }else{
                return $this->sendResponse(404, null, 'Resource not found');
            }
        }catch(Exception $e){
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
