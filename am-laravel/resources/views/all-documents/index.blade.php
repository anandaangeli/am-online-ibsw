@extends('layouts.app')

@section('title', 'Semua Dokumen - AM Online')

@section('styles')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #334155;
        font-size: 13px;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 220px;
        height: 100vh;
        background-color: #0f172a;
        color: #e2e8f0;
        display: flex;
        flex-direction: column;
        z-index: 1040;
        border-right: 1px solid #1e293b;
    }

    .sidebar-header { padding: 16px; background-color: #090d16; border-bottom: 1px solid #1e293b; }
    .brand-title { font-size: 14px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }
    .brand-sub { font-size: 10.5px; color: #64748b; margin-top: 2px; }

    .sidebar-user { padding: 12px 16px; background-color: #141e33; border-bottom: 1px solid #1e293b; display: flex; align-items: center; gap: 10px; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background-color: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }
    .user-name { font-size: 12.5px; font-weight: 600; color: #f1f5f9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px; }
    .user-role { font-size: 11px; color: #94a3b8; }

    .sidebar-menu-wrapper { padding: 12px 8px; flex-grow: 1; overflow-y: auto; }
    .menu-heading { font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.6px; padding: 8px 10px 4px 10px; }
    .sidebar-nav { list-style: none; padding: 0; margin: 0 0 10px 0; }
    .sidebar-nav li { margin-bottom: 3px; }
    .nav-item-link { display: flex; align-items: center; gap: 9px; padding: 8px 12px; color: #94a3b8; text-decoration: none; font-size: 12.5px; font-weight: 500; border-radius: 6px; transition: all 0.15s ease; }
    .nav-item-link i { font-size: 14px; width: 18px; text-align: center; }
    .nav-item-link:hover { background-color: #1e293b; color: #f8fafc; }
    .nav-item-link.active { background-color: #2563eb; color: #ffffff; font-weight: 600; }
    .sidebar-bottom { padding: 12px; background-color: #090d16; border-top: 1px solid #1e293b; }

    .main-wrapper { margin-left: 220px; min-height: 100vh; width: calc(100% - 220px); display: flex; flex-direction: column; }
    .top-header { background-color: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 12px 28px; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; }
    .main-body { padding: 24px 28px; flex-grow: 1; }

    .page-header-box { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px 20px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; }
    .page-subtitle { font-size: 12px; color: #64748b; margin-top: 2px; }

    .table-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); }
    .custom-table { width: 100%; margin-bottom: 0; font-size: 12.5px; }
    .custom-table th { background-color: #f1f5f9; color: #475569; font-weight: 600; font-size: 11.5px; padding: 10px 14px; border-bottom: 1px solid #cbd5e1; white-space: nowrap; }
    .custom-table td { padding: 11px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .custom-table tbody tr:hover { background-color: #f8fafc; }

    .status-tag { font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 4px; display: inline-block; white-space: nowrap; }
    .tag-done { background-color: #dcfce7; color: #15803d; }
    .tag-progress { background-color: #fef3c7; color: #b45309; }
    .tag-rejected { background-color: #fee2e2; color: #b91c1c; }

    .type-badge { font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 4px; }
    .type-br { background-color: #e0f2fe; color: #0369a1; }
    .type-ca { background-color: #fef9c3; color: #854d0e; }

    .btn-xs { font-size: 11.5px; padding: 3px 8px; border-radius: 4px; font-weight: 500; }
</style>
@endsection

@section('content')

@include('layouts.sidebar')

<div class="main-wrapper">
    <header class="top-header">
        <div>
            <strong>Portal HRIS IBSW</strong>
            <span class="text-muted ms-2">&bull; &nbsp;Arsip Semua Dokumen</span>
        </div>
        <div class="text-secondary">
            <i class="bi bi-calendar3 me-1"></i> {{ date('l, d F Y') }}
        </div>
    </header>

    <main class="main-body">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3" style="font-size: 12.5px;" role="alert">
                <strong>Berhasil:</strong> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="page-header-box">
            <div>
                <h1 class="page-title"><i class="bi bi-folder2-open text-primary me-2"></i>Daftar Semua Dokumen AM</h1>
                <div class="page-subtitle">Seluruh riwayat pengajuan Budget Request dan Cash Advance dalam sistem</div>
            </div>
            <div>
                <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12px;">
                    Total Dokumen: <strong>{{ $requests->count() }}</strong>
                </span>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>No. Dokumen</th>
                            <th>Tipe</th>
                            @if($isLeader)
                                <th>Pemohon</th>
                            @endif
                            <th>Perihal Keperluan</th>
                            <th>Kategori</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal</th>
                            <th class="text-center" style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $index => $req)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td><strong>{{ $req->doc_number }}</strong></td>
                                <td>
                                    @if($req->type === 'Cash Advance')
                                        <span class="type-badge type-ca">Cash Advance</span>
                                    @else
                                        <span class="type-badge type-br">Budget Request</span>
                                    @endif
                                </td>
                                @if($isLeader)
                                    <td>
                                        <div class="fw-semibold">{{ $req->user->name ?? '-' }}</div>
                                        <div class="text-muted" style="font-size: 11px;">NIK: {{ $req->user->nik ?? '-' }}</div>
                                    </td>
                                @endif
                                <td>
                                    <div class="fw-semibold">{{ $req->title }}</div>
                                    @if($req->description)
                                        <div class="text-muted" style="font-size: 11px;">{{ Str::limit($req->description, 40) }}</div>
                                    @endif
                                </td>
                                <td>{{ $req->category }}</td>
                                <td class="text-end fw-semibold">
                                    Rp {{ number_format($req->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($req->status === 'Approved')
                                        <span class="status-tag tag-done">Disetujui</span>
                                    @elseif($req->status === 'Pending')
                                        <span class="status-tag tag-progress">Menunggu</span>
                                    @else
                                        <span class="status-tag tag-rejected">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $req->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-outline-primary btn-xs" onclick="bukaDetail({{ json_encode($req) }})">
                                            Lihat
                                        </button>

                                        @if($isLeader && $req->status === 'Pending')
                                            <form action="{{ route('budget-requests.update-status', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Approved">
                                                <button type="submit" class="btn btn-success btn-xs">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif

                                        @if($req->status === 'Pending' && $req->user_id === $user->id)
                                            <form action="{{ route('budget-requests.destroy', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan pengajuan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-xs">
                                                    Batal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isLeader ? 10 : 9 }}" class="text-center py-4 text-muted">
                                    Belum ada data dokumen yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

{{-- Modal Detail Dokumen --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="font-size: 13px;">
            <div class="modal-header bg-light py-2 px-3">
                <h6 class="modal-title fw-bold" id="detailModalTitle">Detail Dokumen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-3">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width: 130px;">Tipe Dokumen</td>
                        <td>: <strong id="detailType">-</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nomor Dokumen</td>
                        <td>: <strong id="detailDocNumber">-</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pemohon</td>
                        <td>: <span id="detailUser">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Perihal</td>
                        <td>: <strong id="detailTitle">-</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kategori</td>
                        <td>: <span id="detailCategory">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Anggaran</td>
                        <td>: <span class="fw-bold text-primary" id="detailAmount">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status Approval</td>
                        <td>: <span id="detailStatus">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pengajuan</td>
                        <td>: <span id="detailDate">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted align-top">Keterangan</td>
                        <td>: <span id="detailDescription">-</span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer bg-light py-2 px-3">
                <button type="button" class="btn btn-secondary btn-xs px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    function bukaDetail(req) {
        document.getElementById('detailType').innerText = req.type || 'Budget Request';
        document.getElementById('detailDocNumber').innerText = req.doc_number;
        document.getElementById('detailUser').innerText = req.user ? (req.user.name + ' (NIK: ' + req.user.nik + ')') : '-';
        document.getElementById('detailTitle').innerText = req.title;
        document.getElementById('detailCategory').innerText = req.category;
        document.getElementById('detailAmount').innerText = formatRupiah(req.amount);
        
        let statusBadge = '';
        if (req.status === 'Approved') {
            statusBadge = '<span class="status-tag tag-done">Disetujui</span>';
        } else if (req.status === 'Pending') {
            statusBadge = '<span class="status-tag tag-progress">Menunggu</span>';
        } else {
            statusBadge = '<span class="status-tag tag-rejected">Ditolak</span>';
        }
        document.getElementById('detailStatus').innerHTML = statusBadge;

        let tgl = new Date(req.created_at);
        document.getElementById('detailDate').innerText = tgl.toLocaleDateString('id-ID', {
            day: '2-digit', month: 'long', year: 'numeric'
        });

        document.getElementById('detailDescription').innerText = req.description ? req.description : '-';

        var myModal = new bootstrap.Modal(document.getElementById('modalDetail'));
        myModal.show();
    }
</script>
@endsection
