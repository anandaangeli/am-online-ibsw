@extends('layouts.app')

@section('title', 'Dashboard - AM Online')

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

    /* Sidebar Kiri */
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

    .sidebar-header {
        padding: 16px;
        background-color: #090d16;
        border-bottom: 1px solid #1e293b;
    }

    .brand-title {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .brand-sub {
        font-size: 10.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .sidebar-user {
        padding: 12px 16px;
        background-color: #141e33;
        border-bottom: 1px solid #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #2563eb;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    .user-name {
        font-size: 12.5px;
        font-weight: 600;
        color: #f1f5f9;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    .user-role {
        font-size: 11px;
        color: #94a3b8;
    }

    .sidebar-menu-wrapper {
        padding: 12px 8px;
        flex-grow: 1;
        overflow-y: auto;
    }

    .menu-heading {
        font-size: 10px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 8px 10px 4px 10px;
    }

    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0 0 10px 0;
    }

    .sidebar-nav li {
        margin-bottom: 3px;
    }

    .nav-item-link {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 12px;
        color: #94a3b8;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.15s ease;
    }

    .nav-item-link i {
        font-size: 14px;
        width: 18px;
        text-align: center;
    }

    .nav-item-link:hover {
        background-color: #1e293b;
        color: #f8fafc;
    }

    .nav-item-link.active {
        background-color: #2563eb;
        color: #ffffff;
        font-weight: 600;
    }

    .sidebar-bottom {
        padding: 12px;
        background-color: #090d16;
        border-top: 1px solid #1e293b;
    }

    /* Area Konten Utama */
    .main-wrapper {
        margin-left: 220px;
        min-height: 100vh;
        width: calc(100% - 220px);
        display: flex;
        flex-direction: column;
    }

    .top-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12.5px;
    }

    .main-body {
        padding: 24px 28px;
        flex-grow: 1;
        max-width: 900px;
    }

    /* Kotak Welcome */
    .welcome-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .welcome-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .welcome-meta {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
    }

    /* 2 Card Saja: AM Progress & AM Done */
    .kpi-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 18px 22px;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .kpi-card.progress-theme {
        border-left: 4px solid #f59e0b;
        background-color: #fffdf5;
    }

    .kpi-card.done-theme {
        border-left: 4px solid #10b981;
        background-color: #f7fef9;
    }

    .kpi-title {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .kpi-sub {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .kpi-number {
        font-size: 26px;
        font-weight: 800;
        line-height: 1;
        margin-top: 12px;
    }

    .kpi-unit {
        font-size: 12px;
        font-weight: 500;
    }
</style>
@endsection

@section('content')

{{-- 1. Sidebar Kiri Terintegrasi --}}
@include('layouts.sidebar')

{{-- 2. Area Konten Utama --}}
<div class="main-wrapper">

    {{-- Top Header --}}
    <header class="top-header">
        <div>
            <strong>Portal HRIS IBSW</strong>
            <span class="text-muted ms-2">&bull; &nbsp;Budget Request & Cash Advance System</span>
        </div>
        <div class="text-secondary">
            <i class="bi bi-calendar3 me-1"></i> {{ date('l, d F Y') }}
        </div>
    </header>

    {{-- Main Body --}}
    <main class="main-body">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3" style="font-size: 12.5px;" role="alert">
                <strong>Berhasil:</strong> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Welcome Card --}}
        <div class="welcome-card">
            <div class="welcome-title">Selamat Datang, {{ $user->name }}</div>
            <div class="welcome-meta">
                Jabatan: <strong>{{ $user->position ?? 'Supervisor' }}</strong> &bull;
                Divisi: <strong>{{ $user->division ?? 'Information Technology & SAP' }}</strong> &bull;
                NIK: <strong>{{ $user->nik }}</strong>
            </div>
        </div>

        {{-- 2 Card Saja: AM Progress & AM Done --}}
        <div class="row g-3">
            {{-- Card 1: AM Progress --}}
            <div class="col-md-6">
                <div class="kpi-card progress-theme">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="kpi-title" style="color: #92400e;">AM PROGRESS</div>
                            <div class="kpi-sub">Pengajuan sedang berjalan / menunggu persetujuan</div>
                        </div>
                        <div class="fs-4" style="color: #d97706;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="kpi-number" style="color: #b45309;">
                        {{ $amProgress }} <span class="kpi-unit" style="color: #92400e;">dokumen</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: AM Done --}}
            <div class="col-md-6">
                <div class="kpi-card done-theme">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="kpi-title" style="color: #065f46;">AM DONE</div>
                            <div class="kpi-sub">Pengajuan selesai dan telah disetujui</div>
                        </div>
                        <div class="fs-4" style="color: #059669;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="kpi-number" style="color: #047857;">
                        {{ $amDone }} <span class="kpi-unit" style="color: #065f46;">dokumen</span>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

@endsection
