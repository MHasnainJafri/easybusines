<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function index()
    {
        return view('admin.index');
    }

    public function Allusers()
    {

        $data = User::all();
        // dd($data);s
        // foreach($data as $value)
        // {
        //     // dd($value);
        //     if($value->status == 1)
        //     {
        //         $value->amount = 0;
        //     }
        // }
        return view('Admin.allusers', compact('data'));
    }

    public function adduser()
    {
        return view('admin.adduser');
    }
    public function uploaduser(Request $request)
    {
        //dd($request->all());
        $data = User::create($request->all());
        //dd($request->all());
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/images', $filename);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('allusers')->with('status', 'User added successfully!');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.updateuser', compact('user'));
    }
    // public function updateuser(Request $request, $id){
    public function updateuser(Request $request, $id)
    {

        // dd('hehehe');
        $user = User::find($id);
        $user->update($request->all());
        $user->save();
        return redirect()->route('allusers')->with('status', 'User updated successfully!');
    }



    // }
    public function payments()
    {

        $payments = Payment::all();
        return view('admin.paymnts', compact('payments'));
    }

    public function action($id)
    {
        $data = Payment::find($id);

              return view('admin.paymentaction', compact('data'));


    }
    public function verify(Request $request, $id)
    {

        $data = Payment::find($id);


        $data->status = '1';
        $user = User::find($data->user->id);
        $user->amount += $data->amount;

        $user->update();
        $data->save();
        return redirect()->route('allpayments', compact('data'));
    }

    public function reject(Request $request, $id)
    {;
        $data = Payment::find($id);


        $data->status = '2';

        $data->save();

        return redirect()->route('allpayments', compact('data'));
        // }

    }

    public function showuser($id)
    {
        $data = User::find($id);
        return view('admin.updateuser', compact('data'));
    }
    public function block(Request $request, $id)
    {
        $data = User::find($id);
        $data->status = 1;
        $data->update();
        return redirect()->route('allusers');
    }
    public function unblock(Request $request, $id)
    {
        $data = User::find($id);
        $data->status = 0;
        $data->update();
        return redirect()->route('allusers');
    }

    public function delete($id)
    {
        $data = User::find($id)->delete();
        return redirect()->route('allusers');
    }

    public function investment()
    {
        $investments = Investment::all();
        return view('admin.investment', compact('investments'));
    }
}
