<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{


    public function Investment(Request $request)
    {

        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }
        //  return $user;
        if ($request->amount <= $user->amount) {
            $investment = Investment::create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),

            ], 200);
        } else {


            return  response()->json([
                'status' => 'fail',
                'mssage' => 'you dont have this balance',
            ], 400);
        }

        $user = User::find($investment->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }
        // $user->amount = $request->amount;
        $user->amount =  $user->amount - $request->amount;
        $user->update();

        return response()->json([
            'status' => 'true',
            'data' => $investment,
        ], 200);
    }
    public function totalinvestments()
    {

        $user = Auth::id();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }
        $investments = Investment::where('created_at', '>=', now()->subDays(28))->where('user_id', $user)
            ->get();
        // $investment_total = array_sum($investments->pluck('amount')->toArray());
        $totalinvestment = array_sum($investments->pluck('amount')->toArray());
        if (!$totalinvestment) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Investment not found',
            ], 404);
        } else {

            return response()->json([
                'status'=>'success',
                'investment_total' => $totalinvestment
            ]);
        }
    }

    public function investmentgraph()
    {

        //    $user =Investment::find($id);
        $user = Auth::id();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
            ], 404);
        }
        $investmentsByMonthYear = Investment::selectRaw('SUM(amount) as total_amount, DATE_FORMAT(created_at, "%m-%Y") as month_year')
            ->groupBy('month_year')
            //    ->orderBy('month_year')
            ->where('user_id', $user)
            ->get();

        // $investment_totals=[];

        $investmentTotals = [];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        foreach ($months as $month) {
            $investmentTotals[$month] = 0;
        }

        foreach ($investmentsByMonthYear as $investment) {
            $monthYear = explode('-', $investment->month_year);
            $month = intval($monthYear[0]);
            $year = intval($monthYear[1]);

            // Only include data for the current year
            if ($year == date('Y')) {
                $investmentTotals[$months[$month - 1]] += $investment->total_amount;
            }
        }

        return response()->json([
            'status'=>'succes',
            'data'=>$investmentTotals
        ]);
    }
}
