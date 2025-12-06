<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PerangkatDaerah;

class ProfileController extends Controller
{
    public function edit()
    {
        // Kirim data user yang sedang login ke view
        $user = Auth::user();

        // Ambil data perangkat daerah untuk dropdown
        $perangkatDaerahs = PerangkatDaerah::where('status_aktivasi', true)
                            ->orderBy('nama', 'asc')
                            ->get();

        // TAMBAH: Get password warning message
        $passwordWarning = $user->getPasswordWarningMessage();

        return view('profile.edit', compact('user', 'perangkatDaerahs', 'passwordWarning'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi dasar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'nullable|string|max:255',
            'nip_no_thl' => 'nullable|string|max:255',
            'no_whatsapp' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Validasi untuk perangkat daerah
        if ($user->canEditPerangkatDaerah()) {
            $request->validate([
                'perangkat_daerah_id' => 'nullable|exists:perangkat_daerah,id',
            ]);
        }

        // Update data profile
        $updateData = $request->except(['current_password', 'new_password', 'new_password_confirmation']);

        // Hanya update perangkat_daerah_id jika user bisa mengedit
        if (!$user->canEditPerangkatDaerah()) {
            unset($updateData['perangkat_daerah_id']);
        }

        $user->update($updateData);

        // Update password jika diisi
        $passwordUpdated = false;
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            // TAMBAH: Update timestamp perubahan password
            $user->updatePasswordChangedAt();
            $passwordUpdated = true;
        }

        // TAMBAH: Cek apakah profil sekarang sudah lengkap
        $message = 'Profile updated successfully.';
        if ($user->isProfileComplete()) {
            $message .= ' Profil Anda sekarang sudah lengkap dan Anda dapat membuat laporan.';
        }

        // TAMBAH: Tambahkan pesan jika password berhasil diubah
        if ($passwordUpdated) {
            $message .= ' Password berhasil diubah.';
        }

        return redirect()->route('profile.edit')->with('success', $message);
    }
}