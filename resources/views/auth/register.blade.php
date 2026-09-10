@extends('layouts.app')

@section('title', 'Daftar Akun Baru - Aruna Coffee')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="kg-card rounded-5 p-4 p-md-5 shadow-lg border" style="border-color: var(--kg-border);">
                
                <div class="text-center mb-4">
                    <div class="avatar-initial mx-auto mb-3" style="width: 58px; height: 58px; font-size: 1.6rem;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h2 class="h3 fw-bold text-white mb-1">Buat Akun Pelanggan</h2>
                    <p class="text-white opacity-85 small">Daftar sekarang untuk memesan kopi favoritmu dengan mudah!</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 text-small" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li class="fw-semibold">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control kg-search-input rounded-3 py-2" 
                               placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control kg-search-input rounded-3 py-2" 
                               placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control kg-search-input rounded-3 py-2" 
                               placeholder="Minimal 6 karakter" required>
                    </div>

                    <button type="submit" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold shadow fs-6">
                        Daftar Akun Sekarang <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--kg-border) !important;">
                    <span class="text-white opacity-85 small">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1" style="color: var(--kg-accent);">
                        Masuk di sini
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection