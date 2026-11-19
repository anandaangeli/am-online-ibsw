<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isLeader = in_array(strtolower($user->role), ['supervisor', 'super admin', 'admin']);
        
        $query = $isLeader ? BudgetRequest::with('user') : BudgetRequest::where('user_id', $user->id);
        
        $requests = (clone $query)->orderBy('created_at', 'desc')->get();

        $amProgress = (clone $query)->where('status', 'Pending')->count();
        $amDone = (clone $query)->where('status', 'Approved')->count();

        return view('dashboard', compact(
            'user',
            'requests',
            'amProgress',
            'amDone',
            'isLeader'
        ));
    }
}
