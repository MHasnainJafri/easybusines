<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //
    public function addcash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:easypaisa,bank',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()
            ], 400);
        }


        if($request->type=='easypaisa')
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:15',
                'easypaisa_account_number' => 'required',
                'amount' => 'required',
                'recipient' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error' => $validator->errors()
                ], 400);
            }


        }
        else     if($request->type=='bank')
        {
            $validator = Validator::make($request->all(), [
               'name' => 'required|max:15',
               'bank_account_number' => 'required',
               'recipient' => 'required',
              'bank_name'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error' => $validator->errors()
                ], 400);
            }


        }



        Auth::user();

        if($request->hasFile('recipient')){
            $recipient=$request->file('recipient');
            $filename=time().'.'.$recipient->getClientOriginalExtension();
            $recipient->move('public/recipient/', $filename);

            // $user->recipient=$request->recipent;
        }
        $user= Payment::create([
            'name' => $request->name,
            'easypaisa_account_number' => $request->easypaisa_account_number,
            'amount' => $request->amount,
            'recipient' => $filename,
            'user_id' => auth()->user()->id,
            'bank_name'=>$request->bank_name,
            'bank_account_number' => $request->bank_account_number,
             ]);
       return response()->json([
        'status'=>'success',
        'data' => $user
       ]);
    }



}
