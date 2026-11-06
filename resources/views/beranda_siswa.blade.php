<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Ujian - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-slate-50 to-violet-50 min-h-screen text-slate-800 flex flex-col justify-between items-center p-4">

    <!-- Header Simpel -->
    <header class="w-full max-w-md mt-6 flex items-center justify-between px-2">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold shadow-md shadow-indigo-600/20">SQ</div>
            <span class="font-bold text-slate-900">SmartQuiz Siswa</span>
        </div>
        <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-sm transition-colors">← Beranda Utama</a>
    </header>

    <!-- Kotak Form Utama -->
    <main class="w-full max-w-md my-auto">
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
            <div class="mb-6 text-center">
                <div class="text-4xl mb-2">🎓</div>
                <h1 class="text-xl font-bold text-slate-900">Portal Ujian Siswa</h1>
                <p class="text-sm text-slate-500 mt-1">Punya kode kuis dari guru? Masukkan nama dan kode untuk mulai ujian.</p>
            </div>

            <!-- Notifikasi Error Jika Kode Salah -->
            @if($errors->has('siswa_error'))
                <div class="mb-5 p-3.5 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm font-medium">
                    {{ $errors->first('siswa_error') }}
                </div>
            @endif

            <!-- Form Masuk Siswa -->
            <form action="{{ url('/masuk-kuis') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <!-- Placeholder diganti menjadi Nuril Rahmadian Hidayat -->
                    <input type="text" name="nama_siswa" required placeholder="Contoh: Nuril Rahmadian Hidayat" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Kode Kuis</label>
                    <input type="text" name="kode_kuis" required placeholder="Contoh: A8X9K2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm uppercase font-mono tracking-wider transition-all bg-slate-50/50">
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/30 text-sm flex items-center justify-center space-x-2 mt-2">
                    <span>Mulai Kerjakan 🚀</span>
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-4 text-center text-xs text-slate-400">
        &copy; 2026 SmartQuiz AI Platform. All rights reserved.
    </footer>

</body>
</html>