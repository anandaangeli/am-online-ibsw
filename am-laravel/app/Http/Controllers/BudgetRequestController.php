<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class BudgetRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isLeader = in_array(strtolower($user->role), ['supervisor', 'super admin', 'admin']);
        
        $query = $isLeader 
            ? BudgetRequest::with('user')->where('type', 'Budget Request') 
            : BudgetRequest::where('user_id', $user->id)->where('type', 'Budget Request');
        
        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('budget-request.index', compact('requests', 'user', 'isLeader'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Budget Request,Cash Advance',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string',
        ], [
            'type.required' => 'Pilih jenis pengajuan',
            'title.required' => 'Perihal pengajuan wajib diisi',
            'category.required' => 'Kategori kebutuhan wajib dipilih',
            'amount.required' => 'Perkiraan biaya wajib diisi',
            'amount.min' => 'Nominal minimal Rp 1.000',
        ]);

        $prefix = $request->type === 'Cash Advance' ? 'CA' : 'BR';
        $year = date('Y');
        $random = str_pad(mt_rand(100, 999), 3, '0', STR_PAD_LEFT);
        $docNumber = "{$prefix}-{$year}-{$random}";

        BudgetRequest::create([
            'user_id' => Auth::id(),
            'doc_number' => $docNumber,
            'type' => $request->type,
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'Pending',
        ]);

        $route = $request->type === 'Cash Advance' ? 'cash-advance.index' : 'budget-request.index';
        return redirect()->route($route)->with('success', "Pengajuan nomor {$docNumber} berhasil dibuat.");
    }

    public function destroy($id)
    {
        $item = BudgetRequest::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        if ($item->status !== 'Pending') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        $nomor = $item->doc_number;
        $item->delete();

        return back()->with('info', "Pengajuan {$nomor} telah dibatalkan.");
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $budgetRequest = BudgetRequest::findOrFail($id);
        $budgetRequest->status = $request->status;
        $budgetRequest->approved_by = Auth::user()->name;
        $budgetRequest->save();

        $pesan = $request->status === 'Approved' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pengajuan {$budgetRequest->doc_number} telah {$pesan}.");
    }
}
