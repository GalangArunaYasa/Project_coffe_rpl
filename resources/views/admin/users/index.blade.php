@extends('layouts.admin')

@section('title', 'Kelola Pengguna & Staf - Admin Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-people me-1"></i> Manajemen Pengguna
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Kelola Pengguna & Akun Staf Kafe
        </h1>
        <p class="text-muted mb-0">Kelola akun staf Administrator, Kasir/Barista Penjual, dan Pelanggan.</p>
    </div>

    <button type="button" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus-fill fs-5"></i> Tambah Akun Baru
    </button>
</div>

<!-- Filter Role Cards -->
<div class="d-flex gap-2 flex-wrap mb-4 pb-1">
    <a href="{{ route('admin.users.index', ['role' => 'semua']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $role === 'semua' ? 'btn-kg-accent text-white' : 'btn-kg-outline' }}">
        Semua Akun ({{ $counts['semua'] }})
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $role === 'admin' ? 'btn-danger text-white' : 'btn-kg-outline' }}">
        <i class="bi bi-shield-lock me-1"></i> Admin ({{ $counts['admin'] }})
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'penjual']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $role === 'penjual' ? 'btn-info text-dark' : 'btn-kg-outline' }}">
        <i class="bi bi-calculator me-1"></i> Penjual / Kasir ({{ $counts['penjual'] }})
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $role === 'customer' ? 'btn-success text-white' : 'btn-kg-outline' }}">
        <i class="bi bi-person me-1"></i> Customer ({{ $counts['customer'] }})
    </a>
</div>

<!-- Users Table -->
<div class="adm-card p-4 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role / Hak Akses</th>
                    <th>Tanggal Terdaftar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initial" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div class="fw-bold text-white">{{ $u->name }}</div>
                            </div>
                        </td>
                        <td class="font-monospace text-light">{{ $u->email }}</td>
                        <td>
                            @if($u->role === 'admin')
                                <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">Administrator</span>
                            @elseif($u->role === 'penjual')
                                <span class="badge bg-info text-dark rounded-pill px-3 py-1 fw-bold">Penjual / Kasir</span>
                            @else
                                <span class="badge bg-success rounded-pill px-3 py-1 fw-bold">Customer</span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ $u->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-kg-outline btn-sm rounded-pill px-3 text-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </button>

                                @if($u->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $u->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-kg-outline btn-sm rounded-circle text-danger" title="Hapus Pengguna">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-white text-start">
                                <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-bottom">
                                        <h5 class="modal-title fw-bold text-warning">
                                            <i class="bi bi-person-gear me-2"></i> Edit Akun: {{ $u->name }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label text-white small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control kg-search-input rounded-3 py-2" value="{{ old('name', $u->name) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control kg-search-input rounded-3 py-2" value="{{ old('email', $u->email) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white small fw-bold">Role / Hak Akses <span class="text-danger">*</span></label>
                                            <select name="role" class="form-select kg-search-input rounded-3 py-2" required>
                                                <option value="admin" @selected($u->role === 'admin')>Administrator (Admin)</option>
                                                <option value="penjual" @selected($u->role === 'penjual')>Penjual / Kasir / Barista</option>
                                                <option value="customer" @selected($u->role === 'customer')>Customer (Pembeli)</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label text-white small fw-bold">Ganti Password (Opsional)</label>
                                            <input type="password" name="password" class="form-control kg-search-input rounded-3 py-2" placeholder="Kosongkan jika tidak ingin mengganti password">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top">
                                        <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-kg-accent rounded-pill px-4 fw-bold">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Tidak ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<!-- Modal Tambah Akun Baru -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white text-start">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-warning">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Akun Staf / Pengguna Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: Barista Baru" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control kg-search-input rounded-3 py-2" placeholder="barista@coffe.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Pilih Role Hak Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-select kg-search-input rounded-3 py-2" required>
                            <option value="penjual" selected>Penjual / Kasir / Barista</option>
                            <option value="admin">Administrator</option>
                            <option value="customer">Customer (Pembeli)</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-white small fw-bold">Password Akun <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control kg-search-input rounded-3 py-2" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-kg-accent rounded-pill px-4 fw-bold">
                        Tambah Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
