@extends('layouts.admin')

@section('title', 'Tambah Karyawan - Kopi Gerobakan')

@section('content')

<div class="mb-4">

    <a href="{{ route('admin.karyawan.index') }}"
       class="text-decoration-none text-muted small">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali ke Data Karyawan

    </a>

    <h1 class="fw-bold mt-3 mb-1">
        Tambah Karyawan
    </h1>

    <p class="text-muted">
        Tambahkan karyawan baru ke sistem.
    </p>

</div>

<div class="content-card">

    <div class="p-4">

        <form
            action="{{ route('admin.karyawan.store') }}"
            method="POST">

            @csrf

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
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
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
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
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx">

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Jabatan
                    </label>

                    <select name="jabatan"
                            class="form-select"
                            required>

                        <option value="">
                            Pilih jabatan
                        </option>

                        <option value="Barista">
                            Barista
                        </option>

                        <option value="Kasir">
                            Kasir
                        </option>

                        <option value="Pelayan">
                            Pelayan
                        </option>

                        <option value="Karyawan">
                            Karyawan
                        </option>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select name="status"
                            class="form-select"
                            required>

                        <option value="offline">
                            Offline
                        </option>

                        <option value="aktif">
                            Aktif
                        </option>

                        <option value="izin">
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

                    <i class="bi bi-person-plus me-1"></i>
                    Simpan Karyawan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection