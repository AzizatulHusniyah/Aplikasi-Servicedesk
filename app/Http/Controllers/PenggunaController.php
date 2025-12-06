<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class);
    }

    public function index()
    {
        // Kirim data users ke view
        $users = User::with('roles')->get();

        return view('pengguna.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_changed_at' => now(), // TAMBAH: Set initial password change date
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('pengguna.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // METHOD BARU: Edit profil pengguna
    public function editProfile($id)
    {
        $user = User::findOrFail($id);
        $perangkatDaerahs = \App\Models\PerangkatDaerah::where('status_aktivasi', true)
                            ->orderBy('nama', 'asc')
                            ->get();

        // TAMBAH: Get password warning message
        $passwordWarning = $user->getPasswordWarningMessage();

        return view('pengguna.edit-profile', compact('user', 'perangkatDaerahs', 'passwordWarning'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('pengguna.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'nullable|string|max:255',
            'nip_no_thl' => 'nullable|string|max:255',
            'no_whatsapp' => 'nullable|string|max:255',
            'perangkat_daerah_id' => 'nullable|exists:perangkat_daerah,id',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update data profile
        $user->update($request->except(['current_password', 'new_password', 'new_password_confirmation']));

        // Update password jika diisi
        $passwordUpdated = false;
        if ($request->filled('current_password')) {
            // Validasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            // Update password baru
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            // TAMBAH: Update timestamp perubahan password
            $user->updatePasswordChangedAt();
            $passwordUpdated = true;
        }

        $message = 'Profil pengguna berhasil diperbarui.';
        if ($passwordUpdated) {
            $message .= ' Password berhasil diubah.';
        }

        return redirect()->route('pengguna.index')->with('success', $message);
    }
}