<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isLeader = BudgetRequestController::isApprover($user);
        
        $query = $isLeader ? BudgetRequest::with('user') : BudgetRequest::where('user_id', $user->id);
        
        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('all-documents.index', compact('requests', 'user', 'isLeader'));
    }
}
