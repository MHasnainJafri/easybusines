<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserprofileControlller extends Controller
{

    public function showprofile()
    {

        $user= Auth::user();

        if($user){
            return response()->json([
                'status'=>'succes',
                 'message'=>'this is your profile',
                 'data'=>$user
            ]);
        }else{
            return response()->json([
                'status'=>'fail',
                'messagae'=>'user not found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateprofile(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|sometimes|string|max:255',
            'phonenumber'=> 'nullable|sometimes|max:11',
            'email' => 'nullable|sometimes|email|max:255|',
            'pin' => 'nullable|sometimes|min:5',
            'confirm_pin' => 'nullable|sometimes|same:pin',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            // add other optional parameters as needed
        ]);

        $validator=Validator::make($request->all(),[

            'pin'=>'required',
            'confirm_pin'=>'required|same:pin'

           ]);

        $user =  Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }else{
        if($request->has('name')){
            $user -> name = $request->input('name');
        }
        if($request->has('phonenumber')){
            $user -> phonenumber = $request->input('phonenumber');
        }
        if($request->has('email')){
            $user -> email = $request->input('email');
        }
        if($request->has('pin')){
            $user -> pin = $request->input('pin');
        }
        if($request->has('confirm_pin')){
            $user -> confirm_pin = $request->input('confirm_pin');
        }

        if ($request->hasFile('image')) {
            // Storage::disk('public_images_profiles')->delete($user->image);

            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move('public/images/', $filename);
            $user->image = $filename;
        }
        $user->save();
         return response()->json([
            'status' => 'success',
            'message' => 'user profile updated',
            'data' => $user
        ]);
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
