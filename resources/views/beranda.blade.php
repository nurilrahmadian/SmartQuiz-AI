<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartQuiz - Platform Evaluasi Pembelajaran AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-slate-50 to-violet-50 min-h-screen text-slate-800 flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="w-full bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-600/20">SQ</div>
                <span class="text-xl font-bold tracking-tight text-slate-900">SmartQuiz</span>
            </div>
            <div>
                <a href="{{ url('/login-guru') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 px-4 py-2 rounded-xl transition-colors">
                    Login Guru 🔐
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 py-20 w-full text-center my-auto space-y-8">
        <div class="inline-flex items-center space-x-2 bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase">
            <span>🎓 Platform Evaluasi Pembelajaran AI</span>
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
            Ujian Interaktif & Pembuatan Bank Soal Berbasis AI
        </h1>
        
        <p class="text-slate-600 text-lg max-w-2xl mx-auto leading-relaxed">
            Platform EdTech cerdas untuk guru dalam merumuskan bank soal secara instan dari materi dokumen, serta memudahkan siswa mengerjakan kuis secara real-time.
        </p>

        <!-- Tombol Pilihan Masuk (Siswa & Guru) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ url('/halaman-siswa') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-indigo-600/30 text-base flex items-center justify-center space-x-2">
                <span>🎓 Masuk sebagai Siswa</span>
            </a>
            <a href="{{ url('/login-guru') }}" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-2xl font-bold transition-all shadow-sm text-base flex items-center justify-center space-x-2">
                <span>👨‍🏫 Masuk sebagai Guru</span>
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-xs text-slate-400 border-t border-slate-200/60 bg-white/40">
        &copy; 2026 SmartQuiz AI Platform. All rights reserved.
    </footer>

</body>
</html>