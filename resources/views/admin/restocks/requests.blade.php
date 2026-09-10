@extends('layouts.admin')

@section('title', 'Persetujuan Permintaan Restok - Admin Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-check2-square me-1"></i> Approval & Verifikasi
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Persetujuan Permintaan Restok dari Penjual
        </h1>
        <p class="text-muted mb-0">Tinjau permohonan penambahan stok kopi dan bahan baku yang diajukan oleh staf kasir/barista kafe.</p>
    </div>

    <a href="{{ route('admin.restocks.index') }}" class="btn btn-kg-outline rounded-pill px-4 py-2">
        <i class="bi bi-box-seam text-warning me-1"></i> Form Restok Manual
    </a>
</div>

<div class="adm-card p-4 shadow-sm mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h2 class="h5 fw-bold text-white mb-0">Daftar Pengajuan Restok</h2>
        @if($pendingCount > 0)
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                {{ $pendingCount }} Permintaan Menunggu Persetujuan
            </span>
        @else
            <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                <i class="bi bi-hand-thumbs-up-fill me-1"></i> Semua Permintaan Telah Diproses
            </span>
        @endif
    </div>

    @if($requests->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Menu Produk</th>
                        <th>Penjual / Kasir</th>
                        <th class="text-center">Jumlah Diminta</th>
                        <th>Alasan Pengajuan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th class="text-end">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                        <tr>
                            <td>
                                <div class="fw-bold text-white fs-6">{{ $req->product->nama }}</div>
                                <small class="text-muted">Sisa stok saat ini: <strong class="text-white">{{ $req->product->stok }} pcs</strong></small>
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $req->penjual ? $req->penjual->name : 'Staff Kasir' }}</div>
                                <small class="text-muted">{{ $req->penjual ? $req->penjual->email : '-' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark fs-6 px-3 py-1 rounded-pill fw-bold">
                                    +{{ $req->jumlah_diminta }} pcs
                                </span>
                            </td>
                            <td>
                                <div class="small text-light">{{ $req->alasan ?? '-' }}</div>
                                @if($req->catatan_admin)
                                    <small class="text-info d-block mt-1">
                                        <em>Respon Admin: "{{ $req->catatan_admin }}"</em>
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($req->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold">
                                        <i class="bi bi-hourglass-split me-1"></i> Pending
                                    </span>
                                @elseif($req->status === 'disetujui')
                                    <span class="badge bg-success rounded-pill px-3 py-1 fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $req->created_at->translatedFormat('d M Y, H:i') }}</small>
                            </td>
                            <td class="text-end">
                                @if($req->status === 'pending')
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- Approve Button Trigger Modal -->
                                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow" data-bs-toggle="modal" data-bs-target="#approveModal{{ $req->id }}">
                                            <i class="bi bi-check-lg me-1"></i> Setujui
                                        </button>

                                        <!-- Reject Button Trigger Modal -->
                                        <button type="button" class="btn btn-kg-outline btn-sm rounded-pill px-3 text-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}">
                                            Tolak
                                        </button>
                                    </div>

                                    <!-- Modal Approve -->
                                    <div class="modal fade" id="approveModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-white text-start">
                                                <form action="{{ route('admin.restocks.requests.approve', $req->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title fw-bold text-success">
                                                            <i class="bi bi-check-circle me-2"></i> Setujui Restok {{ $req->product->nama }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <p class="mb-3 text-white">
                                                            Menyetujui permintaan ini akan secara otomatis menambahkan <strong>+{{ $req->jumlah_diminta }} pcs</strong> ke stok <strong>{{ $req->product->nama }}</strong> (Stok baru: {{ $req->product->stok + $req->jumlah_diminta }} pcs).
                                                        </p>
                                                        <div class="mb-3">
                                                            <label class="form-label text-white small fw-bold">Catatan Persetujuan (Opsional)</label>
                                                            <input type="text" name="catatan_admin" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: Stok bahan baku telah disiapkan untuk operasional kafe">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top">
                                                        <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                            Ya, Setujui & Tambah Stok
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Reject -->
                                    <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-white text-start">
                                                <form action="{{ route('admin.restocks.requests.reject', $req->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title fw-bold text-danger">
                                                            <i class="bi bi-x-circle me-2"></i> Tolak Permintaan Restok
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <p class="mb-3 text-white">
                                                            Berikan alasan penolakan permintaan restok untuk <strong>{{ $req->product->nama }}</strong>:
                                                        </p>
                                                        <div class="mb-3">
                                                            <label class="form-label text-white small fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                                                            <textarea name="catatan_admin" class="form-control kg-search-input rounded-3 py-2" rows="3" placeholder="Contoh: Pasokan bahan baku dari perkebunan sedang dalam perjalanan" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top">
                                                        <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                                                            Tolak Permintaan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @else
                                    <span class="text-muted small">Sudah diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
            Belum ada permintaan restok dari penjual.
        </div>
    @endif
</div>

@endsection
