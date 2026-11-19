<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class CashAdvanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isLeader = in_array(strtolower($user->role), ['supervisor', 'super admin', 'admin']);
        
        $query = $isLeader 
            ? BudgetRequest::with('user')->where('type', 'Cash Advance') 
            : BudgetRequest::where('user_id', $user->id)->where('type', 'Cash Advance');
        
        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('cash-advance.index', compact('requests', 'user', 'isLeader'));
    }
}
