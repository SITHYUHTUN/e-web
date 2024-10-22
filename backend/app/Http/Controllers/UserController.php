<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Js;

use function Laravel\Prompts\error;
use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request){
        $validator=validator($request->all(),[
            "email" => "required",
            "password"=>"required"
        ]);
        if($validator->fails()){
            $errors=$validator->errors();
            return response()->json([
                "status" => "error",
                "error" =>   $errors->all(),
            ]);
        }
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                "status" => "error",
                "error"  => ["email or password is not matched"],
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "User login successful",
            "user"    =>  $user,
        ]);
    
        
    }

    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = validator($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors->all()
            ], 422);
        };
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => "User Register successful",
                'user' => $user,

            ]);
        } else {
            return response()->json([

                "status" => "error",
                "errors" => ["email is already used"],
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
