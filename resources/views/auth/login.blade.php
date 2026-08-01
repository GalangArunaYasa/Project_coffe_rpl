@extends('layouts.app')

@section('title', 'Masuk - Kopi Gerobakan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="kg-card rounded-4 p-4 p-md-5 shadow-lg">
                
                <div class="text-center mb-4">
                    <i class="bi bi-cup-hot-fill fs-1" style="color: var(--kg-accent);"></i>
                    <h3 class="fw-bold text-white mt-2 mb-1">Selamat Datang!</h3>
                    <p class="text-white small">Masuk untuk mulai pesan kopi favoritmu.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 text-small" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 text-small" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-white small">Alamat Email</label>
                        <input type="email" name="email" class="form-control kg-search-input rounded-3" 
                               placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small">Password</label>
                        <input type="password" name="password" class="form-control kg-search-input rounded-3" 
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-kg-accent w-100 rounded-3 py-2 fw-semibold">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-white">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--kg-accent);">
                            Daftar di sini
                        </a>
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection