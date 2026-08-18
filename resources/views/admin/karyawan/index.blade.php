@extends('layouts.admin')

@section('title', 'Data Karyawan - Kopi Gerobakan')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">

    <div>
        <span class="text-uppercase fw-bold"
              style="
                color: var(--kg-gold-deep);
                font-size: .72rem;
                letter-spacing: .12em;
              ">
            Manajemen
        </span>

        <h1 class="fw-bold mb-1">
            Data Karyawan
        </h1>

        <p class="text-muted mb-0">
            Kelola data dan status karyawan Kopi Gerobakan.
        </p>
    </div>

    <a href="{{ route('admin.karyawan.create') }}"
       class="btn btn-kg-primary rounded-pill px-4">

        <i class="bi bi-person-plus-fill me-1"></i>
        Tambah Karyawan

    </a>

</div>

@if(session('success'))

    <div class="alert alert-success border-0 shadow-sm">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>

@endif

@if($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif

{{-- FILTER --}}
<div class="content-card mb-4">

    <div class="p-3">

        <form method="GET"
              action="{{ route('admin.karyawan.index') }}">

            <div class="row g-2">

                <div class="col-md-7">

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama, email, atau jabatan..."
                            value="{{ request('search') }}">

                    </div>

                </div>

                <div class="col-md-3">

                    <select name="status"
                            class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="aktif"
                            {{ request('status') == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="offline"
                            {{ request('status') == 'offline' ? 'selected' : '' }}>
                            Offline
                        </option>

                        <option value="izin"
                            {{ request('status') == 'izin' ? 'selected' : '' }}>
                            Izin
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <button class="btn btn-dark w-100">

                        <i class="bi bi-funnel me-1"></i>
                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- TABLE --}}
<div class="content-card">

    <div class="content-card-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h4 class="mb-1 fw-bold">
                    Daftar Karyawan
                </h4>

                <small class="text-muted">
                    Total {{ $karyawans->total() }} karyawan
                </small>

            </div>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>

                <tr>

                    <th>Karyawan</th>
                    <th>No. HP</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($karyawans as $karyawan)

                <tr>

                    {{-- KARYAWAN --}}
                    <td>

                        <div class="d-flex align-items-center gap-3">

                            <div class="employee-avatar">
                                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
                            </div>

                            <div>

                                <div class="fw-bold">
                                    {{ $karyawan->nama }}
                                </div>

                                <small class="text-muted">
                                    {{ $karyawan->email }}
                                </small>

                            </div>

                        </div>

                    </td>

                    {{-- NO HP --}}
                    <td>
                        {{ $karyawan->no_hp ?? '-' }}
                    </td>

                    {{-- JABATAN --}}
                    <td>
                        {{ $karyawan->jabatan }}
                    </td>

                    {{-- STATUS --}}
                    <td>

                        @if($karyawan->status === 'aktif')

                            <span class="fw-semibold small"
                                  style="color: var(--kg-olive);">

                                <span class="status-dot status-active"></span>

                                Aktif

                            </span>

                        @elseif($karyawan->status === 'izin')

                            <span class="fw-semibold small"
                                  style="color: var(--kg-gold-deep);">

                                <span class="status-dot status-permission"></span>

                                Izin

                            </span>

                        @else

                            <span class="text-muted fw-semibold small">

                                <span class="status-dot status-offline"></span>

                                Offline

                            </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                    <td class="text-end">

                        <a href="{{ route('admin.karyawan.show', $karyawan) }}"
                           class="btn btn-sm btn-outline-dark rounded-pill">

                            <i class="bi bi-eye"></i>

                        </a>

                        <a href="{{ route('admin.karyawan.edit', $karyawan) }}"
                           class="btn btn-sm btn-outline-warning rounded-pill">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form
                            action="{{ route('admin.karyawan.destroy', $karyawan) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger rounded-pill">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-5">

                        <i class="bi bi-people fs-1 text-muted"></i>

                        <p class="text-muted mt-2 mb-0">
                            Belum ada data karyawan.
                        </p>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    @if($karyawans->hasPages())

        <div class="p-3 border-top">

            {{ $karyawans->links() }}

        </div>

    @endif

</div>

@endsection