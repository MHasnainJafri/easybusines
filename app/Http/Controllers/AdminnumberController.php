<?php

namespace App\Http\Controllers;

use App\Models\Adminnumber;
use Illuminate\Http\Request;

class AdminnumberController extends Controller
{
    //
    public function adminnumber(Request $request){
        $admin=$request->all();

        $admin=Adminnumber::create($admin);

        return response()->json([
            'status'=>'success',
        ]);
    }

    public function showadminnumber(){
        $admin=Adminnumber::get()->all();
        return response()->json([
            'data'=>$admin
        ]);
    }
}
