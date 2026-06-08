<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Exception;

class GoogleController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman autentikasi Google.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback setelah autentikasi dari Google berhasil.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        try {
            // Mengambil data pengguna dari Google secara aman
            $googleUser = Socialite::driver('google')->user();
            
            /* * CATATAN/SOLUSI ALTERNATIF:
             * Jika Anda tetap menemui error InvalidStateException di localhost (karena isu session cookie),
             * Anda bisa menghapus komentar baris di bawah dan mengomentari baris di atas:
             */
            // $googleUser = Socialite::driver('google')->stateless()->user();

        } catch (InvalidStateException $e) {
            // Menangani error InvalidStateException agar tidak crash 500
            return redirect('/login')->with('error', 'Sesi masuk Google telah kedaluwarsa atau tidak valid. Silakan coba kembali.');
        } catch (Exception $e) {
            // Menangani segala jenis error lainnya (misal: koneksi timeout, client_id salah, dll)
            return redirect('/login')->with('error', 'Gagal masuk menggunakan Google. Silakan coba beberapa saat lagi.');
        }

        // Mencari atau membuat akun customer baru berdasarkan email dari Google
        $customer = CustomerAccount::firstOrCreate(
            [
                'email' => $googleUser->email
            ],
            [
                'name' => $googleUser->name,
                'profile_photo' => $googleUser->avatar,
                'status' => true,
                'provider' => 'google',
                'email_verified' => true,
            ]
        );

        // Jika akun lama dibuat sebelum ada kolom provider, maka kita perbarui kolom provider-nya
        if (!$customer->provider) {
            $customer->provider = 'google';
            $customer->save();
        }

        // Melakukan login menggunakan session (kembali ke sistem jm 4 sore)
        session(['customer_id' => $customer->id]);

        // Mengarahkan pengguna kembali ke halaman utama setelah berhasil login
        return redirect()->route('customer.account')->with('success', 'Berhasil masuk menggunakan akun Google!');
    }
}