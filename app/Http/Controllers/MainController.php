<?php

namespace App\Http\Controllers;

use App\Models\Forgotpin;
use App\Models\User;
use Twilio\Rest\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;
use Psy\Command\WhereamiCommand;

class MainController extends Controller
{
    //
    public function Register(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phonenumber' => 'required|unique:users,phonenumber',
            'referal_id' => 'nullable|exists:users,referal_code',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }

        $referalCode = "";
        do {
            $referalCode = strtoupper(Str::random(8));
        } while (User::where('referal_code', $referalCode)->exists());
        $referal_usr = "";
        if ($request->has('referal_id')) {
            $referal_id = $request->input('referal_id');

            $referal_usr = User::where('referal_code', $referal_id)->get()->first();
            if ($referal_usr != null) {
                $referal_usr = $referal_usr->id;
            }
        }

        //---start otp-------------------

        // $sid = getenv("TWILIO_SID");
        // $token = getenv("TWILIO_TOKEN");
        // $sendernumber = getenv("TWILIO_FROM");
        // $twilio = new Client($sid, $token);
        $otp = rand(10000, 99999);

        // $message = $twilio->messages
        //     ->create(
        //         '+92 318 8485570',
        //         [
        //             "body" => "Your OTP is $otp",
        //             "from" => $sendernumber
        //         ]
        //     );

        $user = User::create(array_merge($input, [
            'referal_code' => $referalCode,
            'referal_id' => $referal_usr,
            'otp' => $otp
        ]));
        // -----  end otp --------


        // token
        $success['token'] = $user->createtoken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return response([
            'status' => 'active',
            'message' => 'user registration successfull',
            'data' => $user
        ]);
    }
    public function Registerotp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'otp' => 'required|exists:users,otp',

        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }


        $otp = user::where('otp', $request->otp);
        if (!$otp) {
            return response()->json([
                'status' => 'fails',
                'message' => 'invalid otp'
            ], 404);
        } else {

            return response()->json([
                'status' => 'succes',
                'message' => 'valid otp'
            ], 200);
        }
    }



    public function storepin(Request $request)
    {

        // Validate the input
        $validator = Validator::make($request->all(), [

            'pin' => 'required',
            'confirm_pin' => 'required|same:pin'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }

        // Update the user with pin and confirm_pin
        $user = User::where(['phonenumber' => $request->phonenumber])->get()->first();
        // $user=auth()->user();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }

        if ($user->pin !== null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Pin of this user already set',
            ], 400);
        }
        $user->pin =  $request->pin;
        $user->confirm_pin = $request->confirm_pin;
        $user->save();

        return response()->json([
            'status' => 'succes',
            'message' => 'succesfull',
            'data' => [$user->toArray()]
        ], 200);
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phonenumber' => 'required|exists:users,phonenumber',
            'pin' => 'required',

        ]
        , [
            'phonenumber.exists' => 'The phone number you entered does not exist in our records.',
        ]);


        // $user =auth()->user();
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }
        $user = User::where(['phonenumber' => $request->phonenumber, 'pin' => $request->pin])->first();

        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'error' => 'Invalid phone number or PIN'
            ], 400);
        }
        $success['token'] = $user->createtoken('MyApp')->plainTextToken;
        $success['name'] = $user->name;



            return response()->json([
                'status' => 'success',
                'message' => 'login successfull',
                'Token' => $success,
                'data' => [$user->toArray()]

            ], 200);
        }

    public function changepin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_pin' => 'required|exists:users,pin',
            'pin' => 'required',
            'confirm_pin' => 'required|same:pin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }


        $user = Auth::user();


        if ($user->pin !== $request->old_pin) {
            return response()->json(['error' => 'Old pin does not match'], 401);
        }
        $user->pin = $request->pin;
        $user->confirm_pin = $request->confirm_pin;
        $user->update([
            'pin' => $request->pin,
            'confirm_pin' => $request->confirm_pin
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'updated successfull',
            'data' => [$user->toArray()]
        ], 200);
    }




    //  forget pin//



    public function Verifyphone(Request $request)
    {

        // dd('sdfghjkl;');
        $validator = Validator::make($request->all(), [
            'phonenumber' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }
        //   Auth::user();
        $otp = Rand(10000, 99999);
        $user = User::where(['phonenumber' => $request->phonenumber])->get()->first();

        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        } else {
            $user = Forgotpin::updateOrCreate([
                'phonenumber' => $request->phonenumber,
            ],[
                'phonenumber' => $request->phonenumber,
                'otp' => $otp
            ]);
            return response()->json([
                'status' => 'success',
                'data' => [$user->toArray()]
            ]);
        }
    }
    public function otpverify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }

        $user = Forgotpin::where(['otp' => $request->otp])->first();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        } else {
            return response()->json([
                'status' => 'success',
                'otp' => 'Valid otp'
            ], 200);
        }
    }

    public function createNewPin(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            // 'phonenumber' => 'required',
            'new_pin' => 'required|string',
            'confirm_pin' => 'required|string|same:new_pin',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }
        // Update user table with new pin
        $user = User::where('phonenumber', $request->input('phonenumber'))->first();

        if ($user) {
            $user->pin = $request->input('new_pin');
            $user->confirm_pin = $request->input('confirm_pin');
            $user->update();
        } else {
            // Return error response if user not found
            return response()->json(['error' => 'User not found.'], 404);
        }


        if (Forgotpin::where('phonenumber', $request->input('phonenumber'))->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Dont Share this Pin With Others',
            ], 200);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Forgot pin entry not found or already deleted',
            ], 400);
        }
    }
    public function logout(Request $request)
    {


        // Check if user is authenticated and has an access token
        if ($request->user()->token()) {
            // Revoke the user's access token
            $request->user()->token()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'User is not authenticated or already logged out',
            ], 400);
        }
    }

    public function verifyuserpayment($id)
    {
        $payment = Payment::where('id', $id)->first();
        if ($payment->status = 1) {
            return response()->json([
                'message' => 'The Paymnt Already Verify'
            ]);
        } elseif ($payment) {
            $payment->status = 1;
            $payment->save();
            $user = User::find($payment->user_id);
            $user->amount = $payment->amount;
            $user->update();

            return response()->json([
                'status' => 'success',
                'message' => 'verification complete',
            ], 200);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'payment not found',
            ], 404);
        }
    }
}
