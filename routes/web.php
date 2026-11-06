<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Models\Kuis;
use App\Models\Soal;
use App\Models\HasilSiswa;

// Halaman Publik
Route::get('/', function () {
    return view('beranda');
});

// Fitur Masuk Siswa
Route::post('/masuk-kuis', function (Request $request) {
    $kuis = Kuis::where('kode_kuis', $request->kode_kuis)->first();
    if (!$kuis) {
        return back()->withErrors(['siswa_error' => 'Kode Kuis tidak ditemukan.']);
    }
    session(['nama_siswa' => $request->nama_siswa, 'kuis_aktif_id' => $kuis->id]);
    return redirect('/kerjakan-kuis');
});

// Halaman Pengerjaan Soal Siswa
Route::get('/kerjakan-kuis', function () {
    if (!session('kuis_aktif_id') || !session('nama_siswa')) {
        return redirect('/');
    }
    $kuis = Kuis::find(session('kuis_aktif_id'));
    $daftar_soal = Soal::where('kuis_id', $kuis->id)->get();
    return view('dashboard_siswa', [
        'nama_siswa' => session('nama_siswa'),
        'kuis' => $kuis,
        'daftar_soal' => $daftar_soal
    ]);
});

// Menghitung Skor Siswa
Route::post('/hitung-skor', function (Request $request) {
    $kuis_id = session('kuis_aktif_id');
    $nama_siswa = session('nama_siswa');

    if (!$kuis_id || !$nama_siswa) {
        return redirect('/');
    }

    $soals = Soal::where('kuis_id', $kuis_id)->get();
    $total_soal = $soals->count();
    $benar = 0;

    $jawaban_siswa = $request->input('jawaban');
    foreach ($soals as $soal) {
        if (isset($jawaban_siswa[$soal->id]) && $jawaban_siswa[$soal->id] == $soal->jawaban_benar) {
            $benar++;
        }
    }

    $skor = $total_soal > 0 ? round(($benar / $total_soal) * 100) : 0;

    HasilSiswa::create([
        'kuis_id' => $kuis_id,
        'nama_siswa' => $nama_siswa,
        'skor' => $skor
    ]);

    session()->forget(['nama_siswa', 'kuis_aktif_id']);

    return view('hasil_kuis', ['skor' => $skor, 'benar' => $benar, 'total' => $total_soal, 'nama' => $nama_siswa]);
});

// Jalur Login & Register Guru
Route::get('/login-guru', function () {
    return view('login_guru');
})->name('login');
Route::post('/login-guru', [AuthController::class, 'login']);
Route::post('/register-guru', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Terproteksi (Harus Login Guru)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-guru', function () {
        $kuis_guru = Kuis::where('guru_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('dashboard_guru', ['kuisList' => $kuis_guru]);
    });

    Route::get('/upload-materi', function () {
        return view('upload_materi');
    });

    Route::post('/generate-kuis', [QuizController::class, 'generate']);

    // Rute Detail Kuis & Rekap Siswa
    Route::get('/kuis/{id}', function ($id) {
        $kuis = Kuis::where('id', $id)->where('guru_id', Auth::id())->firstOrFail();
        $daftar_soal = Soal::where('kuis_id', $id)->get();
        $hasil_siswa = HasilSiswa::where('kuis_id', $id)->orderBy('created_at', 'desc')->get();

        return view('lihat_soal', [
            'kuis' => $kuis,
            'daftar_soal' => $daftar_soal,
            'hasil_siswa' => $hasil_siswa
        ]);
    });

    Route::get('/detail-kuis/{id}', function ($id) {
        $kuis = Kuis::where('id', $id)->where('guru_id', Auth::id())->firstOrFail();
        $daftar_soal = Soal::where('kuis_id', $id)->get();
        $hasil_siswa = HasilSiswa::where('kuis_id', $id)->orderBy('created_at', 'desc')->get();

        return view('lihat_soal', [
            'kuis' => $kuis,
            'daftar_soal' => $daftar_soal,
            'hasil_siswa' => $hasil_siswa
        ]);
    });

    // Route Hapus Kuis
    Route::delete('/kuis/{id}', [QuizController::class, 'destroy']);
});

// Halaman Publik Beranda Utama
Route::get('/', function () {
    return view('beranda');
});

// Halaman Khusus Masuk Siswa
Route::get('/halaman-siswa', function () {
    return view('beranda_siswa');
});
