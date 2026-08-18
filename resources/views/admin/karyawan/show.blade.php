@extends('layouts.admin')

@section('title', 'Detail Karyawan - Kopi Gerobakan')

@section('content')

<div class="mb-4">

    <a href="{{ route('admin.karyawan.index') }}"
       class="text-decoration-none text-muted small">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali

    </a>

</div>

<div class="content-card">

    <div class="p-4">

        <div class="d-flex align-items-center gap-4">

            <div class="employee-avatar"
                 style="
                    width:80px;
                    height:80px;
                    font-size:2rem;
                 ">

                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}

            </div>

            <div>

                <h2 class="fw-bold mb-1">
                    {{ $karyawan->nama }}
                </h2>

                <div class="text-muted">
                    {{ $karyawan->jabatan }}
                </div>

                <div class="mt-2">

                    @if($karyawan->status === 'aktif')

                        <span style="color:var(--kg-olive);"
                              class="fw-semibold">

                            ● Aktif

                        </span>

                    @elseif($karyawan->status === 'izin')

                        <span style="color:var(--kg-gold-deep);"
                              class="fw-semibold">

                            ● Izin

                        </span>

                    @else

                        <span class="text-muted fw-semibold">

                            ● Offline

                        </span>

                    @endif

                </div>

            </div>

        </div>

        <hr>

        <div class="row g-4">

            <div class="col-md-6">

                <small class="text-muted">
                    Email
                </small>

                <div class="fw-semibold">
                    {{ $karyawan->email }}
                </div>

            </div>

            <div class="col-md-6">

                <small class="text-muted">
                    No. HP
                </small>

                <div class="fw-semibold">
                    {{ $karyawan->no_hp ?? '-' }}
                </div>

            </div>

            <div class="col-md-6">

                <small class="text-muted">
                    Jabatan
                </small>

                <div class="fw-semibold">
                    {{ $karyawan->jabatan }}
                </div>

            </div>

            <div class="col-md-6">

                <small class="text-muted">
                    Bergabung
                </small>

                <div class="fw-semibold">
                    {{ $karyawan->created_at->format('d F Y') }}
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">

            <a href="{{ route('admin.karyawan.edit', $karyawan) }}"
               class="btn btn-outline-warning rounded-pill px-4">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

            <a href="{{ route('admin.karyawan.index') }}"
               class="btn btn-dark rounded-pill px-4">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection