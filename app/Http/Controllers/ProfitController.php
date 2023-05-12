<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investment;
use App\Models\Payment;
use App\Models\Profit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfitController extends Controller
{
    //
    public function profit()
    {
        return view('admin.Profit');
    }
    public function userdetail($id)
    {

        $investments = Investment::where('user_id', $id)->get();
        //   dd($id);
        $payments = Payment::where('user_id', $id)->get();
        $profit=Profit::where('user_id' , $id)->get();
        return view('admin.Profit', compact('investments', 'payments','profit', 'id'));
    }
    public function userprofit(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        $profit = new Profit();
        $profit->amount =  $request->amount;
        $profit->user_id = $user->id;
        $profit->save();

        $user->amount += $request->amount;
        $user->save();

        return redirect()->route('allusers' ,compact('profit'));
    }


    public function totalprofit()
    {

        $user = Auth::id();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }
        $profit = Profit::where('created_at', '>=', now()->subDays(28))->where('user_id', $user)
            ->get();
        // $investment_total = array_sum($investments->pluck('amount')->toArray());
        $totalprofit = array_sum($profit->pluck('amount')->toArray());
        if (!$totalprofit) {
            return response()->json([
                'status' => 'fail',
                'message' => 'profit not found',
            ], 404);
        } else {

            return response()->json([
                'status'=>'success',
                'investment_total' => $totalprofit
            ]);
        }
    }


}
