@extends('layouts.app')

@section('title', 'Pengajuan AM - AM Online')

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
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background-color: #e61037; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }
    .user-name { font-size: 12.5px; font-weight: 600; color: #f1f5f9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px; }
    .user-role { font-size: 11px; color: #94a3b8; }

    .sidebar-menu-wrapper { padding: 12px 8px; flex-grow: 1; overflow-y: auto; }
    .menu-heading { font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.6px; padding: 8px 10px 4px 10px; }
    .sidebar-nav { list-style: none; padding: 0; margin: 0 0 10px 0; }
    .sidebar-nav li { margin-bottom: 3px; }
    .nav-item-link { display: flex; align-items: center; gap: 9px; padding: 8px 12px; color: #94a3b8; text-decoration: none; font-size: 12.5px; font-weight: 500; border-radius: 6px; transition: all 0.15s ease; }
    .nav-item-link i { font-size: 14px; width: 18px; text-align: center; }
    .nav-item-link:hover { background-color: #1e293b; color: #f8fafc; }
    .nav-item-link.active { background-color: #e61037; color: #ffffff; font-weight: 600; }
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

    .btn-xs { font-size: 11.5px; padding: 3px 8px; border-radius: 4px; font-weight: 500; }
    .btn-create { font-size: 12.5px; font-weight: 600; padding: 6px 14px; border-radius: 5px; }
    .btn-primary { background-color: #e61037; border-color: #e61037; }
    .btn-primary:hover, .btn-primary:focus { background-color: #d00e31; border-color: #d00e31; }
</style>
@endsection

@section('content')

@include('layouts.sidebar')

<div class="main-wrapper">
    <header class="top-header">
        <div>
            <strong>Portal HRIS IBSW</strong>
            <span class="text-muted ms-2">&bull; &nbsp;Pengajuan AM (Anggaran Manajemen)</span>
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

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show py-2 px-3 mb-3" style="font-size: 12.5px;" role="alert">
                <strong>Info:</strong> {{ session('info') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="page-header-box">
            <div>
                <h1 class="page-title"><i class="bi bi-file-earmark-text text-danger me-2"></i>Pengajuan Dokumen AM</h1>
                <div class="page-subtitle">Daftar permohonan alokasi anggaran proyek dan operasional divisi (AM)</div>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-create" data-bs-toggle="modal" data-bs-target="#modalTambahBR">
                    <i class="bi bi-plus-lg me-1"></i> Buat Dokumen AM
                </button>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>No. Dokumen</th>
                            @if($isLeader)
                                <th>Pemohon</th>
                            @endif
                            <th>Perihal</th>
                            <th>Kategori</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $index => $req)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td><strong>{{ $req->doc_number }}</strong></td>
                                @if($isLeader)
                                    <td>
                                        <div class="fw-semibold">{{ $req->user->name ?? '-' }}</div>
                                        <div class="text-muted" style="font-size: 11px;">NIK: {{ $req->user->nik ?? '-' }}</div>
                                    </td>
                                @endif
                                <td>
                                    <div class="fw-semibold text-dark">{{ $req->title }}</div>
                                    @if($req->description)
                                        <div class="text-muted" style="font-size: 11px;">{{ Str::limit($req->description, 45) }}</div>
                                    @endif

                                    {{-- Keterangan Status AM / CA di kolom Perihal --}}
                                    @php $ca = $req->cashAdvances->first(); @endphp

                                    @if($req->status === 'Pending')
                                        <div class="mt-1">
                                            <span class="badge bg-light text-muted border px-1" style="font-size: 10px;">
                                                <i class="bi bi-hourglass me-1"></i> Menunggu Persetujuan Atasan
                                            </span>
                                        </div>
                                    @endif

                                    @if($ca)
                                        <div class="mt-1">
                                            <a href="javascript:void(0)" onclick="bukaDetailCA({{ json_encode($ca) }})" class="text-decoration-none d-inline-flex align-items-center gap-1" title="Klik untuk lihat detail Cash Advance">
                                                <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1" style="font-size: 10.5px;">
                                                    <i class="bi bi-wallet2 me-1"></i> CA: <strong>{{ $ca->doc_number }}</strong> (Rp {{ number_format($ca->amount, 0, ',', '.') }})
                                                </span>
                                                @if($ca->status === 'Approved')
                                                    <span class="badge bg-success" style="font-size: 9.5px;">CA Disetujui</span>
                                                @elseif($ca->status === 'Pending')
                                                    <span class="badge bg-warning text-dark" style="font-size: 9.5px;">CA Menunggu</span>
                                                @else
                                                    <span class="badge bg-danger" style="font-size: 9.5px;">CA Ditolak</span>
                                                @endif
                                            </a>
                                        </div>
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
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-xs" onclick="bukaDetail({{ json_encode($req) }})">
                                            Detail
                                        </button>

                                        {{-- Tombol Buat CA hanya jika AM sudah Approved dan belum ada CA aktif --}}
                                        @if($req->status === 'Approved' && (!$ca || $ca->status === 'Rejected'))
                                            <button type="button" class="btn btn-warning btn-xs fw-bold text-dark shadow-sm" onclick="bukaModalCreateCA('{{ $req->doc_number }}', '{{ addslashes($req->title) }}', {{ $req->amount }})" title="Ajukan Kas Bon (CA) untuk AM ini">
                                                <i class="bi bi-wallet2 me-1"></i> + Buat CA
                                            </button>
                                        @endif

                                        {{-- Tombol Otorisasi Approver --}}
                                        @php 
                                            $canApprove = \App\Http\Controllers\BudgetRequestController::canApproveDocument($user, $req);
                                        @endphp

                                        @if($canApprove)
                                            <form action="{{ route('budget-requests.update-status', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Approved">
                                                <button type="submit" class="btn btn-success btn-xs" title="Setujui dokumen ini">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('budget-requests.update-status', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Rejected">
                                                <button type="submit" class="btn btn-outline-danger btn-xs" title="Tolak dokumen ini" onclick="return confirm('Tolak dokumen ini?');">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol Batal bagi Requester --}}
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
                                <td colspan="{{ $isLeader ? 9 : 8 }}" class="text-center py-4 text-muted">
                                    Belum ada data pengajuan Dokumen AM.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

{{-- Modal Tambah Dokumen AM --}}
<div class="modal fade" id="modalTambahBR" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="font-size: 13px;">
            <div class="modal-header bg-light py-2 px-3">
                <h6 class="modal-title fw-bold">Buat Pengajuan Dokumen AM</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('budget-request.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="AM">
                <div class="modal-body p-3">
                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Kategori:</label>
                        <select class="form-select form-select-sm" name="category" required>
                            <option value="Operasional Kantor" selected>Operasional Kantor</option>
                            <option value="Teknologi & IT">Perlengkapan IT & Komputer</option>
                            <option value="Peralatan Kerja">Peralatan Kerja</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Perihal / Keperluan:</label>
                        <input type="text" class="form-control form-control-sm" name="title" placeholder="Contoh: Pengadaan Tinta & Kertas HVS" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Perkiraan Biaya (Nominal Rp):</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="amount" placeholder="Contoh: 1500000" min="1000" step="1000" required>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold" style="font-size: 12px;">Keterangan Singkat:</label>
                        <textarea class="form-control form-control-sm" name="description" rows="2" placeholder="Tuliskan justifikasi singkat..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 px-3">
                    <button type="button" class="btn btn-secondary btn-xs px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-xs px-3">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalLihatDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="font-size: 12.5px;">
            <div class="modal-header bg-light py-2 px-3">
                <h6 class="modal-title fw-bold">Rincian Dokumen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-3">
                <table class="table table-sm table-bordered mb-0" style="font-size: 12px;">
                    <tr>
                        <th style="width: 35%; background: #f8fafc;">No. Dokumen</th>
                        <td id="detailDoc" class="fw-bold">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Perihal</th>
                        <td id="detailPerihal" class="fw-semibold">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Kategori</th>
                        <td id="detailKat">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Nominal Biaya</th>
                        <td id="detailBiaya" class="fw-bold text-primary">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Status</th>
                        <td id="detailStat">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Tanggal Dibuat</th>
                        <td id="detailTgl">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Keterangan</th>
                        <td id="detailKet">-</td>
                    </tr>
                    <tr id="rowPenyetuju" style="display: none;">
                        <th style="background: #f0fdf4; color: #166534;">Disetujui Oleh</th>
                        <td id="detailAppr" class="fw-bold text-success">-</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer bg-light py-2 px-3">
                <button type="button" class="btn btn-secondary btn-xs px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Buat Cash Advance Langsung dari AM --}}
<div class="modal fade" id="modalCreateCAFromAM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="font-size: 13px;">
            <div class="modal-header bg-light py-2 px-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-wallet2 text-warning fs-5"></i>
                    <h6 class="modal-title fw-bold m-0">Buat Pengajuan Cash Advance (Kas Bon)</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('budget-request.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="Cash Advance">
                <input type="hidden" name="am_reference" id="caModalAmRef">

                <div class="modal-body p-3">
                    {{-- Box Info AM Terkait --}}
                    <div class="p-2 mb-3 rounded bg-light border">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted" style="font-size: 11px;">DASAR DOKUMEN AM TERKAIT:</span>
                            <span class="badge bg-danger text-white px-2 py-1" id="caModalAmBadge" style="font-size: 11px;">-</span>
                        </div>
                        <div class="fw-semibold text-dark" id="caModalAmTitle" style="font-size: 12.5px;">-</div>
                        <div class="text-muted mt-1" style="font-size: 11px;">
                            Total Anggaran AM: <strong class="text-dark" id="caModalAmAmount">-</strong>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Kategori Pengeluaran: <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" name="category" required>
                            <option value="Perjalanan Dinas" selected>Perjalanan Dinas / Transportasi</option>
                            <option value="Operasional Lapangan">Operasional Lapangan / Lapangan Proyek</option>
                            <option value="Darurat Operasional">Darurat Operasional Kantor</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Perihal / Keperluan Kas Bon: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="title" id="caModalTitle" placeholder="Contoh: Uang saku dan tiket perjalanan dinas" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold" style="font-size: 12px;">Nominal Kas Bon yang Diajukan (Rp): <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="amount" id="caModalAmount" placeholder="Contoh: 2500000" min="1000" step="1000" required>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label fw-bold" style="font-size: 12px;">Rincian Penggunaan:</label>
                        <textarea class="form-control form-control-sm" name="description" rows="2" placeholder="Tuliskan justifikasi kas bon untuk AM ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 px-3">
                    <button type="button" class="btn btn-secondary btn-xs px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-xs px-3" style="background-color: #e61037; border-color: #e61037;">
                        <i class="bi bi-send me-1"></i> Kirim Pengajuan CA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Cash Advance Terkait --}}
<div class="modal fade" id="modalLihatDetailCA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="font-size: 12.5px;">
            <div class="modal-header bg-light py-2 px-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-wallet2 text-warning fs-5"></i>
                    <h6 class="modal-title fw-bold m-0">Detail Cash Advance Terkait</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-3">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th style="width: 35%; background: #f8fafc;">No. Dokumen CA</th>
                        <td id="detailCaDoc" class="fw-bold text-dark">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Dasar Dokumen AM</th>
                        <td id="detailCaAmRef" class="fw-semibold text-danger">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Perihal Kas Bon</th>
                        <td id="detailCaTitle" class="fw-semibold">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Kategori</th>
                        <td id="detailCaCategory">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Nominal Diajukan</th>
                        <td id="detailCaAmount" class="fw-bold text-primary">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Status Kas Bon</th>
                        <td id="detailCaStatus">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Tanggal Pengajuan</th>
                        <td id="detailCaDate">-</td>
                    </tr>
                    <tr>
                        <th style="background: #f8fafc;">Rincian Penggunaan</th>
                        <td id="detailCaDesc">-</td>
                    </tr>
                    <tr id="rowCaApprovedBy" style="display: none;">
                        <th style="background: #f0fdf4; color: #166534;">Disetujui Oleh</th>
                        <td id="detailCaApprovedBy" class="fw-bold text-success">-</td>
                    </tr>
                </table>

                @if($isLeader)
                    <div id="boxApproveCA" class="mt-3 pt-2 border-top text-end" style="display: none;">
                        <form id="formApproveCA" action="" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Approved">
                            <button type="submit" class="btn btn-success btn-xs px-3">
                                <i class="bi bi-check-circle me-1"></i> Setujui Cash Advance Ini
                            </button>
                        </form>
                    </div>
                @endif
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
    function bukaDetailCA(ca) {
        document.getElementById('detailCaDoc').textContent = ca.doc_number;
        document.getElementById('detailCaAmRef').textContent = ca.am_reference || '-';
        document.getElementById('detailCaTitle').textContent = ca.title;
        document.getElementById('detailCaCategory').textContent = ca.category;
        document.getElementById('detailCaAmount').textContent = 'Rp ' + Number(ca.amount).toLocaleString('id-ID');
        
        const tgl = new Date(ca.created_at);
        document.getElementById('detailCaDate').textContent = tgl.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric'
        });
        
        document.getElementById('detailCaDesc').textContent = ca.description || '-';
        
        const statElem = document.getElementById('detailCaStatus');
        if (ca.status === 'Approved') {
            statElem.innerHTML = '<span class="status-tag tag-done">Disetujui</span>';
        } else if (ca.status === 'Pending') {
            statElem.innerHTML = '<span class="status-tag tag-progress">Menunggu</span>';
        } else {
            statElem.innerHTML = '<span class="status-tag tag-rejected">Ditolak</span>';
        }
        
        const rowAppr = document.getElementById('rowCaApprovedBy');
        if (ca.approved_by) {
            document.getElementById('detailCaApprovedBy').textContent = ca.approved_by;
            rowAppr.style.display = '';
        } else {
            rowAppr.style.display = 'none';
        }
        
        const boxApprove = document.getElementById('boxApproveCA');
        if (boxApprove) {
            const isApproverUser = {{ \App\Http\Controllers\BudgetRequestController::isApprover($user) ? 'true' : 'false' }};
            const currentUserId = {{ $user->id }};
            if (isApproverUser && ca.status === 'Pending' && ca.user_id !== currentUserId) {
                boxApprove.style.display = '';
                document.getElementById('formApproveCA').action = '/budget-requests/' + ca.id + '/status';
            } else {
                boxApprove.style.display = 'none';
            }
        }
        
        const modal = new bootstrap.Modal(document.getElementById('modalLihatDetailCA'));
        modal.show();
    }
    function bukaModalCreateCA(docNumber, amTitle, amAmount) {
        document.getElementById('caModalAmRef').value = docNumber;
        document.getElementById('caModalAmBadge').innerText = docNumber;
        document.getElementById('caModalAmTitle').innerText = amTitle;
        document.getElementById('caModalAmAmount').innerText = 'Rp ' + Number(amAmount).toLocaleString('id-ID');
        document.getElementById('caModalTitle').value = 'Kas Bon: ' + amTitle;
        document.getElementById('caModalAmount').value = '';
        
        const modal = new bootstrap.Modal(document.getElementById('modalCreateCAFromAM'));
        modal.show();
    }
    function bukaDetail(data) {
        document.getElementById('detailDoc').textContent = data.doc_number;
        document.getElementById('detailPerihal').textContent = data.title;
        document.getElementById('detailKat').textContent = data.category;
        document.getElementById('detailBiaya').textContent = 'Rp ' + Number(data.amount).toLocaleString('id-ID');
        
        const tgl = new Date(data.created_at);
        document.getElementById('detailTgl').textContent = tgl.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric'
        });

        document.getElementById('detailKet').textContent = data.description || '-';

        const statElem = document.getElementById('detailStat');
        if (data.status === 'Approved') {
            statElem.innerHTML = '<span class="status-tag tag-done">Disetujui</span>';
        } else if (data.status === 'Pending') {
            statElem.innerHTML = '<span class="status-tag tag-progress">Menunggu</span>';
        } else {
            statElem.innerHTML = '<span class="status-tag tag-rejected">Ditolak</span>';
        }

        const rowPenyetuju = document.getElementById('rowPenyetuju');
        if (data.approved_by) {
            document.getElementById('detailAppr').textContent = data.approved_by;
            rowPenyetuju.style.display = '';
        } else {
            rowPenyetuju.style.display = 'none';
        }

        const modal = new bootstrap.Modal(document.getElementById('modalLihatDetail'));
        modal.show();
    }
</script>
@endsection
