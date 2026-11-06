<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kuis AI - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold">SQ</div>
                <h1 class="text-lg font-bold text-slate-900">Buat Kuis Otomatis Berbasis AI</h1>
            </div>
            <a href="{{ url('/dashboard-guru') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">← Kembali ke Dashboard</a>
        </div>
    </header>

    <!-- Main Form -->
    <main class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden p-8 sm:p-10">
            
            <div class="mb-8">
                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Generator AI Cerdas</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-2">Tempel Materi & Atur Kuis</h2>
                <p class="text-sm text-slate-500 mt-1">Salin dan tempel ringkasan materi pelajaran, lalu AI akan merumuskan bank soal pilihan ganda secara otomatis.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/generate-kuis') }}" method="POST" class="space-y-6" onsubmit="showLoading()">
                @csrf

                <!-- Judul Kuis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Judul Kuis</label>
                    <input type="text" name="judul" required placeholder="Contoh: Ujian Evaluasi Informatika Kelas 9 - Bab Logika" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-slate-50/50 transition-all">
                </div>

                <!-- Jumlah Soal (Kelipatan 5, Maksimal 30) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jumlah Soal</label>
                    <select name="jumlah_soal" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-slate-50/50 transition-all font-medium">
                        <option value="" disabled selected>Pilih jumlah soal...</option>
                        <option value="5">5 Soal Pilihan Ganda</option>
                        <option value="10">10 Soal Pilihan Ganda</option>
                        <option value="15">15 Soal Pilihan Ganda</option>
                        <option value="20">20 Soal Pilihan Ganda</option>
                        <option value="25">25 Soal Pilihan Ganda</option>
                        <option value="30">30 Soal Pilihan Ganda</option>
                    </select>
                </div>

                <!-- Kotak Teks Materi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Materi Pelajaran (Salin & Tempel di Sini)</label>
                    <textarea name="teks_materi" rows="6" required placeholder="Tempel ringkasan materi atau isi modul pembelajaran di sini agar AI bisa membacanya dengan akurat..." class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-slate-50/50 transition-all"></textarea>
                </div>

                <!-- Instruksi AI (Prompt) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Instruksi Khusus AI (Prompt)</label>
                    <textarea name="prompt" rows="3" required placeholder="Contoh: Buatkan soal yang berfokus pada gerbang logika AND, OR, dan NOT dengan tingkat kesulitan sedang..." class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-slate-50/50 transition-all"></textarea>
                </div>

                <!-- Tombol Submit & Indikator Loading -->
                <div class="pt-4">
                    <button type="submit" id="submit-btn" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/30 text-sm flex items-center justify-center space-x-2">
                        <span>🚀 Mulai Proses AI & Buat Kuis</span>
                    </button>
                    
                    <div id="loading-box" class="hidden text-center py-6 space-y-3">
                        <div class="inline-block w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-sm font-semibold text-slate-600">Sedang merumuskan bank soal dengan AI... Harap tunggu sebentar.</p>
                    </div>
                </div>

            </form>
        </div>
    </main>

    <script>
        function showLoading() {
            document.getElementById('submit-btn').classList.add('hidden');
            document.getElementById('loading-box').classList.remove('hidden');
        }
    </script>
</body>
</html>