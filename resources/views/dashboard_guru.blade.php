<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-md shadow-indigo-600/20">SQ</div>
                <h1 class="text-xl font-bold text-slate-900">SmartQuiz <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-semibold ml-2">Panel Guru</span></h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- NAMA GURU DINAMIS SESUAI AKUN YANG LOGIN -->
                <span class="text-sm font-medium text-slate-600">Halo, <strong class="text-slate-900">{{ Auth::user()->name ?? 'Guru' }}</strong></span>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition-colors">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-2xl shadow-sm flex items-center justify-between">
                <span class="font-medium text-sm">{{ session('success') }}</span>
                <span class="text-emerald-400 font-bold">✓</span>
            </div>
        @endif

        <!-- Banner & Tombol Buat Kuis -->
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-600/10 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Kelola Bank Soal & Kuis AI 📚</h2>
                <p class="text-indigo-100 text-sm max-w-xl">Unggah materi pembelajaran Anda, biarkan sistem merumuskan soal secara cerdas, dan pantau hasil evaluasi siswa dengan mudah.</p>
            </div>
            <a href="{{ url('/upload-materi') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 font-bold px-6 py-3.5 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5 text-sm whitespace-nowrap flex items-center space-x-2">
                <span>+ Buat Kuis Baru AI</span>
            </a>
        </div>

        <!-- Daftar Kuis Section -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-lg text-slate-900">Daftar Kuis Aktif Anda</h3>
                <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-3 py-1 rounded-full">{{ isset($kuisList) ? count($kuisList) : 0 }} Kuis Terdaftar</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-400 uppercase text-xs font-semibold tracking-wider">
                            <th class="py-4 px-6">Judul Kuis</th>
                            <th class="py-4 px-6">Kode Akses</th>
                            <th class="py-4 px-6">Tanggal Dibuat</th>
                            <th class="py-4 px-6 text-center">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($kuisList ?? [] as $kuis)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 font-semibold text-slate-900">{{ $kuis->judul }}</td>
                                <td class="py-4 px-6">
                                    <span class="bg-indigo-50 text-indigo-700 font-mono font-bold px-3 py-1 rounded-lg text-xs tracking-wider border border-indigo-100">{{ $kuis->kode_kuis }}</span>
                                </td>
                                <td class="py-4 px-6 text-slate-500 text-xs">{{ $kuis->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Tombol Detail / Lihat Soal -->
                                        <a href="{{ url('/kuis/' . $kuis->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-xl transition-colors text-xs">Detail</a>

                                        <!-- Tombol Hapus Kuis -->
                                        <form action="{{ url('/kuis/' . $kuis->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kuis ini? Semua data soal dan hasil siswa akan ikut terhapus permanen.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl transition-colors text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <div class="text-3xl mb-2">📂</div>
                                    <p class="font-medium">Belum ada kuis yang dibuat.</p>
                                    <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Buat Kuis Baru AI" di atas untuk mulai membuat bank soal.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>