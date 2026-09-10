@extends('layouts.app')

@section('title', 'Masuk Akun - Aruna Coffee House')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="kg-card rounded-5 p-4 p-md-5 shadow-lg border" style="border-color: var(--kg-border);">
                
                <div class="text-center mb-4">
                    <div class="avatar-initial mx-auto mb-3" style="width: 58px; height: 58px; font-size: 1.6rem;">
                        <i class="bi bi-cup-hot-fill"></i>
                    </div>
                    <h2 class="h3 fw-bold text-white mb-1">Masuk ke Akun</h2>
                    <p class="text-white opacity-85 small">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>
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

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control kg-search-input rounded-3 py-2" 
                               placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label text-white small fw-bold mb-0">Password</label>
                        </div>
                        <input type="password" name="password" class="form-control kg-search-input rounded-3 py-2" 
                               placeholder="••••••••" required>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-white opacity-85 small" for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold shadow fs-6">
                        Masuk Sekarang <i class="bi bi-box-arrow-in-right ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--kg-border) !important;">
                    <span class="text-white opacity-85 small">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-1" style="color: var(--kg-accent);">
                        Daftar Akun Baru
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection