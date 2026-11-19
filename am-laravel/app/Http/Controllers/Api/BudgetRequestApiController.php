<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BudgetRequest;
use App\Models\User;

class BudgetRequestApiController extends Controller
{
    public function index(Request $request)
    {
        $query = BudgetRequest::with('user:id,nik,name,role,position,division');

        if ($request->has('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $item = BudgetRequest::with('user:id,nik,name,role,position,division')->find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Dokumen tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'nullable|string',
            'type' => 'required|in:Budget Request,Cash Advance',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string',
        ]);

        $user = null;
        if ($request->filled('nik')) {
            $user = User::where('nik', $request->input('nik'))->first();
        }
        if (!$user) {
            $user = User::first();
        }

        $prefix = $request->type === 'Cash Advance' ? 'CA' : 'BR';
        $year = date('Y');
        $random = str_pad(mt_rand(100, 999), 3, '0', STR_PAD_LEFT);
        $docNumber = "{$prefix}-{$year}-{$random}";

        $created = BudgetRequest::create([
            'user_id' => $user->id,
            'doc_number' => $docNumber,
            'type' => $request->type,
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'Pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pengajuan berhasil dibuat',
            'data' => $created
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'approved_by' => 'nullable|string',
        ]);

        $item = BudgetRequest::find($id);
        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Dokumen tidak ditemukan'
            ], 404);
        }

        $item->status = $request->status;
        $item->approved_by = $request->approved_by ?? 'Supervisor System';
        $item->save();

        return response()->json([
            'status' => true,
            'message' => 'Status dokumen berhasil diperbarui',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = BudgetRequest::find($id);
        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Dokumen tidak ditemukan'
            ], 404);
        }

        if ($item->status !== 'Pending') {
            return response()->json([
                'status' => false,
                'message' => 'Pengajuan yang sudah diproses tidak dapat dibatalkan'
            ], 400);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Dokumen berhasil dibatalkan / dihapus'
        ]);
    }
}
