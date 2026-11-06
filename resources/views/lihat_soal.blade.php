<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuis & Rekap Siswa - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold">SQ</div>
                <h1 class="text-lg font-bold text-slate-900">Detail Kuis & Rekap Nilai</h1>
            </div>
            <a href="{{ url('/dashboard-guru') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">← Kembali ke Dashboard</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 space-y-8">

        <!-- Informasi Kuis & Kode Akses -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Kuis Aktif</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-2">{{ $kuis->judul }}</h2>
                <p class="text-xs text-slate-400 mt-1">Dibuat pada: {{ $kuis->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="bg-slate-50 border border-slate-200 px-6 py-4 rounded-2xl text-center">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Kode Akses Siswa</p>
                <span class="text-2xl font-mono font-bold text-indigo-600 tracking-widest">{{ $kuis->kode_kuis }}</span>
            </div>
        </div>

        <!-- Bagian 1: Tabel Rekap Nilai Siswa (BARU) -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-lg text-slate-900">📊 Rekap Nilai Siswa yang Sudah Mengerjakan</h3>
                <span class="text-xs bg-emerald-100 text-emerald-700 font-semibold px-3 py-1 rounded-full">{{ count($hasil_siswa ?? []) }} Siswa Selesai</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-400 uppercase text-xs font-semibold tracking-wider">
                            <th class="py-3 px-6">No</th>
                            <th class="py-3 px-6">Nama Siswa</th>
                            <th class="py-3 px-6">Skor Akhir</th>
                            <th class="py-3 px-6">Waktu Pengumpulan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($hasil_siswa ?? [] as $index => $hasil)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3 px-6 text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 font-semibold text-slate-900">{{ $hasil->nama_siswa }}</td>
                                <td class="py-3 px-6">
                                    <span class="font-bold px-3 py-1 rounded-lg text-xs {{ $hasil->skor >= 70 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                        {{ $hasil->skor }} Poin
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-slate-500 text-xs">{{ $hasil->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400 text-sm">
                                    Belum ada siswa yang menyelesaikan kuis ini. Bagikan kode kuis <strong class="text-indigo-600 font-mono">{{ $kuis->kode_kuis }}</strong> kepada siswa Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bagian 2: Daftar Soal Pilihan Ganda -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 space-y-6">
            <h3 class="font-bold text-lg text-slate-900 border-b border-slate-100 pb-4">📝 Daftar Soal & Kunci Jawaban</h3>

            <div class="space-y-6">
                @foreach($daftar_soal as $index => $soal)
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">Soal No. {{ $index + 1 }}</span>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">Kunci: Opsi {{ $soal->jawaban_benar }}</span>
                        </div>
                        <p class="font-semibold text-slate-900 text-base">{{ $soal->pertanyaan }}</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2 text-sm">
                            <div class="p-3 rounded-xl border {{ $soal->jawaban_benar == 'A' ? 'bg-emerald-50/60 border-emerald-200 font-medium text-emerald-900' : 'bg-white border-slate-200 text-slate-600' }}">
                                <strong>A.</strong> {{ $soal->opsi_a }}
                            </div>
                            <div class="p-3 rounded-xl border {{ $soal->jawaban_benar == 'B' ? 'bg-emerald-50/60 border-emerald-200 font-medium text-emerald-900' : 'bg-white border-slate-200 text-slate-600' }}">
                                <strong>B.</strong> {{ $soal->opsi_b }}
                            </div>
                            <div class="p-3 rounded-xl border {{ $soal->jawaban_benar == 'C' ? 'bg-emerald-50/60 border-emerald-200 font-medium text-emerald-900' : 'bg-white border-slate-200 text-slate-600' }}">
                                <strong>C.</strong> {{ $soal->opsi_c }}
                            </div>
                            <div class="p-3 rounded-xl border {{ $soal->jawaban_benar == 'D' ? 'bg-emerald-50/60 border-emerald-200 font-medium text-emerald-900' : 'bg-white border-slate-200 text-slate-600' }}">
                                <strong>D.</strong> {{ $soal->opsi_d }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </main>
</body>
</html>