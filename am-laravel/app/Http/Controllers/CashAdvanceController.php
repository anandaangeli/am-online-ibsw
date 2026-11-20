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
        
        // Daftar Cash Advance
        $query = $isLeader 
            ? BudgetRequest::with('user')->where('type', 'Cash Advance') 
            : BudgetRequest::where('user_id', $user->id)->where('type', 'Cash Advance');
        
        $requests = $query->orderBy('created_at', 'desc')->get();

        // Dokumen AM yang sudah Approved sebagai prasyarat pembuatan Cash Advance
        $amQuery = BudgetRequest::whereIn('type', ['AM', 'Budget Request'])
            ->where('status', 'Approved');
            
        if (!$isLeader) {
            $amQuery->where('user_id', $user->id);
        }

        $availableAms = $amQuery->orderBy('created_at', 'desc')->get();
        $hasApprovedAm = $availableAms->count() > 0;

        return view('cash-advance.index', compact('requests', 'user', 'isLeader', 'availableAms', 'hasApprovedAm'));
    }
}
