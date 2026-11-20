<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BudgetRequest;

class BudgetRequestController extends Controller
{
    /**
     * Cek apakah user memiliki peran Approver (Penyetujui).
     */
    public static function isApprover($user)
    {
        if (!$user) return false;
        $role = strtolower(trim($user->role));
        
        // Requester dan Staff biasa BUKAN approver
        if (in_array($role, ['staff', 'requester', 'karyawan', 'user'])) {
            return false;
        }

        // Role yang berhak menjadi Approver
        $approverKeywords = ['asisten', 'kadiv', 'accounting', 'tax', 'sap', 'admin', 'head', 'manager', 'supervisor'];
        foreach ($approverKeywords as $keyword) {
            if (str_contains($role, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cek apakah user berhak menyetujui dokumen tertentu.
     * Aturan: Approver TIDAK BISA menyetujui dokumen miliknya sendiri (No Self-Approval).
     */
    public static function canApproveDocument($user, $document)
    {
        if (!self::isApprover($user)) {
            return false;
        }

        // Larangan menyetujui pengajuan milik sendiri
        if ($document->user_id === $user->id) {
            return false;
        }

        return $document->status === 'Pending';
    }

    public function index()
    {
        $user = Auth::user();
        $isApprover = self::isApprover($user);
        
        // Approver melihat semua dokumen untuk keperluan review; Requester hanya melihat miliknya
        $query = $isApprover 
            ? BudgetRequest::with(['user', 'cashAdvances'])->whereIn('type', ['AM', 'Budget Request']) 
            : BudgetRequest::with('cashAdvances')->where('user_id', $user->id)->whereIn('type', ['AM', 'Budget Request']);
        
        $requests = $query->orderBy('created_at', 'desc')->get();
        $isLeader = $isApprover;

        return view('budget-request.index', compact('requests', 'user', 'isApprover', 'isLeader'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:AM,Cash Advance,Budget Request',
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

        $type = in_array($request->type, ['AM', 'Budget Request']) ? 'AM' : 'Cash Advance';
        $amReference = null;

        // Aturan: Tidak bisa membuat Cash Advance jika tidak ada dokumen AM yang disetujui
        if ($type === 'Cash Advance') {
            $request->validate([
                'am_reference' => 'required|string',
            ], [
                'am_reference.required' => 'Nomor Referensi Dokumen AM wajib dipilih untuk membuat Cash Advance.',
            ]);

            $amReference = trim($request->am_reference);
            $isApprover = self::isApprover(Auth::user());

            $amQuery = BudgetRequest::whereIn('type', ['AM', 'Budget Request'])
                ->where('doc_number', $amReference)
                ->where('status', 'Approved');

            if (!$isApprover) {
                $amQuery->where('user_id', Auth::id());
            }

            $amValid = $amQuery->exists();

            if (!$amValid) {
                return back()->withErrors([
                    'am_reference' => 'Cash Advance tidak dapat dibuat. Dokumen AM referensi tidak valid atau belum berstatus Approved (Disetujui).',
                ])->withInput();
            }
        }

        $prefix = $type === 'Cash Advance' ? 'CA' : 'AM';
        $year = date('Y');
        $random = str_pad(mt_rand(100, 999), 3, '0', STR_PAD_LEFT);
        $docNumber = "{$prefix}-{$year}-{$random}";

        BudgetRequest::create([
            'user_id' => Auth::id(),
            'doc_number' => $docNumber,
            'type' => $type,
            'am_reference' => $amReference,
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'Pending',
        ]);

        $pesanSukses = $type === 'Cash Advance'
            ? "Pengajuan Cash Advance nomor {$docNumber} berhasil diajukan untuk Dokumen AM {$amReference}. Status: Menunggu Persetujuan Atasan."
            : "Pengajuan Dokumen AM nomor {$docNumber} berhasil dibuat. Status: Menunggu Persetujuan Atasan.";

        return redirect()->route('budget-request.index')->with('success', $pesanSukses);
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

        $user = Auth::user();
        $budgetRequest = BudgetRequest::findOrFail($id);

        // Proteksi 1: Pastikan akun adalah Approver
        if (!self::isApprover($user)) {
            return back()->with('error', 'Akses ditolak: Akun Anda terdaftar sebagai Requester (Pemohon) dan tidak memiliki hak wewenang untuk menyetujui dokumen.');
        }

        // Proteksi 2: Larangan menyetujui dokumen sendiri (No Self-Approval)
        if ($budgetRequest->user_id === $user->id) {
            return back()->with('error', 'Akses ditolak: Anda tidak dapat menyetujui pengajuan yang Anda buat sendiri. Persetujuan harus dilakukan oleh akun atasan atau pejabat penilai lain.');
        }

        $budgetRequest->status = $request->status;
        $budgetRequest->approved_by = $user->name . ' (' . ($user->position ?: $user->role) . ')';
        $budgetRequest->save();

        $pesan = $request->status === 'Approved' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pengajuan {$budgetRequest->doc_number} telah {$pesan} oleh {$budgetRequest->approved_by}.");
    }
}
