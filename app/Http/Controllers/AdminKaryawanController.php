<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:karyawans,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:100'],
            'status' => [
                'required',
                Rule::in(['aktif', 'offline', 'izin'])
            ],
        ]);

        Karyawan::create($validated);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('karyawans', 'email')
                    ->ignore($karyawan->id),
            ],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:100'],
            'status' => [
                'required',
                Rule::in(['aktif', 'offline', 'izin'])
            ],
        ]);

        $karyawan->update($validated);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}