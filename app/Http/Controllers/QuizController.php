<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\Soal;
use App\Models\HasilSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class QuizController extends Controller

{
    public function generate(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'judul' => 'required',
            'jumlah_soal' => 'required|integer|in:5,10,15,20,25,30',
            'prompt' => 'required',
            'teks_materi' => 'required|string|min:5'
        ]);

        $jumlahSoal = (int) $request->jumlah_soal;

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (empty($apiKey) || empty($model)) {
            return back()->withInput()->with(
                'error',
                'Konfigurasi Gemini API belum lengkap.'
            );
        }

        $promptTeks = "
Bertindaklah sebagai pembuat soal ujian profesional.

Judul Kuis:
{$request->judul}

Instruksi Guru:
{$request->prompt}

Materi Pembelajaran:
{$request->teks_materi}

TUGAS:
Buat tepat {$jumlahSoal} soal pilihan ganda.

KETENTUAN:
1. Setiap soal memiliki pilihan A, B, C, dan D.
2. Hanya ada satu jawaban benar.
3. Soal harus relevan dengan materi.
4. Hindari soal yang berulang.
5. Gunakan bahasa Indonesia yang jelas.
6. Kunci jawaban harus A, B, C, atau D.

Kembalikan hanya JSON Array dengan format:

[
    {
        \"pertanyaan\": \"Pertanyaan soal\",
        \"opsi_a\": \"Pilihan A\",
        \"opsi_b\": \"Pilihan B\",
        \"opsi_c\": \"Pilihan C\",
        \"opsi_d\": \"Pilihan D\",
        \"jawaban_benar\": \"A\"
    }
]
";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        try {

            $response = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json'
            ])
                ->acceptJson()
                ->timeout(120)
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $promptTeks
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'temperature' => 0.7
                    ]
                ]);

            if (!$response->successful()) {

                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                return back()->withInput()->with(
                    'error',
                    'Gemini API gagal. HTTP Status: '
                        . $response->status()
                );
            }

            $aiTeks = $response->json(
                'candidates.0.content.parts.0.text'
            );

            if (!is_string($aiTeks) || trim($aiTeks) === '') {
                return back()->withInput()->with(
                    'error',
                    'Gemini tidak menghasilkan soal.'
                );
            }

            $aiTeks = trim($aiTeks);

            $aiTeks = preg_replace(
                '/^\s*```(?:json)?\s*/i',
                '',
                $aiTeks
            );

            $aiTeks = preg_replace(
                '/\s*```\s*$/',
                '',
                $aiTeks
            );

            $daftarSoal = json_decode($aiTeks, true);

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($daftarSoal) ||
                count($daftarSoal) !== $jumlahSoal
            ) {
                Log::error('Gemini JSON Error', [
                    'message' => json_last_error_msg()
                ]);

                return back()->withInput()->with(
                    'error',
                    'Format JSON tidak valid atau jumlah soal tidak sesuai.'
                );
            }

            foreach ($daftarSoal as $soal) {

                if (!is_array($soal)) {
                    return back()->withInput()->with(
                        'error',
                        'Format data soal tidak valid.'
                    );
                }

                $fields = [
                    'pertanyaan',
                    'opsi_a',
                    'opsi_b',
                    'opsi_c',
                    'opsi_d',
                    'jawaban_benar'
                ];

                foreach ($fields as $field) {
                    if (
                        !isset($soal[$field]) ||
                        !is_string($soal[$field]) ||
                        trim($soal[$field]) === ''
                    ) {
                        return back()->withInput()->with(
                            'error',
                            'Terdapat bagian soal yang belum lengkap.'
                        );
                    }
                }

                if (!in_array(
                    strtoupper(trim($soal['jawaban_benar'])),
                    ['A', 'B', 'C', 'D'],
                    true
                )) {
                    return back()->withInput()->with(
                        'error',
                        'Kunci jawaban AI tidak valid.'
                    );
                }
            }
        } catch (Throwable $e) {

            Log::error('SmartQuiz AI Exception', [
                'message' => $e->getMessage()
            ]);

            return back()->withInput()->with(
                'error',
                'Terjadi kesalahan saat menghubungkan ke Gemini AI.'
            );
        }

        try {

            DB::transaction(function () use (
                $request,
                $daftarSoal,
                $jumlahSoal
            ) {

                $kode = strtoupper(Str::random(8));

                $kuis = Kuis::create([
                    'guru_id' => Auth::id(),
                    'judul' => $request->judul,
                    'kode_kuis' => $kode
                ]);

                foreach ($daftarSoal as $soal) {

                    Soal::create([
                        'kuis_id' => $kuis->id,
                        'pertanyaan' => $soal['pertanyaan'],
                        'opsi_a' => $soal['opsi_a'],
                        'opsi_b' => $soal['opsi_b'],
                        'opsi_c' => $soal['opsi_c'],
                        'opsi_d' => $soal['opsi_d'],
                        'jawaban_benar' => strtoupper(
                            trim($soal['jawaban_benar'])
                        )
                    ]);
                }
            });
        } catch (Throwable $e) {

            Log::error('SmartQuiz Database Error', [
                'message' => $e->getMessage()
            ]);

            return back()->withInput()->with(
                'error',
                'Gagal menyimpan soal ke database.'
            );
        }

        return redirect('/dashboard-guru')->with(
            'success',
            "Berhasil! Kuis '{$request->judul}' dengan {$jumlahSoal} soal berhasil dibuat."
        );
    }

    public function destroy($id)
    {
        $kuis = Kuis::where('id', $id)
            ->where('guru_id', Auth::id())
            ->firstOrFail();

        DB::transaction(function () use ($kuis) {

            Soal::where('kuis_id', $kuis->id)->delete();

            HasilSiswa::where('kuis_id', $kuis->id)->delete();

            $kuis->delete();
        });

        return redirect('/dashboard-guru')->with(
            'success',
            'Kuis berhasil dihapus!'
        );
    }
}
