@extends('layouts.admin')

@section('title', 'Edit Karyawan - Kopi Gerobakan')

@section('content')

<div class="mb-4">

    <a href="{{ route('admin.karyawan.index') }}"
       class="text-decoration-none text-muted small">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali ke Data Karyawan

    </a>

    <h1 class="fw-bold mt-3 mb-1">
        Edit Karyawan
    </h1>

    <p class="text-muted">
        Perbarui informasi {{ $karyawan->nama }}.
    </p>

</div>

<div class="content-card">

    <div class="p-4">

        <form
            action="{{ route('admin.karyawan.update', $karyawan) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama', $karyawan->nama) }}"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $karyawan->email) }}"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control"
                        value="{{ old('no_hp', $karyawan->no_hp) }}">

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Jabatan
                    </label>

                    <select name="jabatan"
                            class="form-select"
                            required>

                        @foreach([
                            'Barista',
                            'Kasir',
                            'Pelayan',
                            'Karyawan'
                        ] as $jabatan)

                            <option value="{{ $jabatan }}"
                                {{ old('jabatan', $karyawan->jabatan) == $jabatan ? 'selected' : '' }}>

                                {{ $jabatan }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select name="status"
                            class="form-select"
                            required>

                        <option value="aktif"
                            {{ old('status', $karyawan->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="offline"
                            {{ old('status', $karyawan->status) == 'offline' ? 'selected' : '' }}>
                            Offline
                        </option>

                        <option value="izin"
                            {{ old('status', $karyawan->status) == 'izin' ? 'selected' : '' }}>
                            Izin
                        </option>

                    </select>

                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a href="{{ route('admin.karyawan.index') }}"
                   class="btn btn-outline-secondary rounded-pill px-4">

                    Batal

                </a>

                <button type="submit"
                        class="btn btn-kg-primary rounded-pill px-4">

                    <i class="bi bi-save me-1"></i>
                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection