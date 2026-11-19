<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isLeader = in_array(strtolower($user->role), ['supervisor', 'super admin', 'admin']);
        
        $query = $isLeader ? BudgetRequest::with('user') : BudgetRequest::where('user_id', $user->id);
        
        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('all-documents.index', compact('requests', 'user', 'isLeader'));
    }
}
