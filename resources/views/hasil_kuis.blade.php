<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-slate-100 text-center">
        
        <!-- Icon/Emoji dinamis berdasarkan skor -->
        <div class="text-7xl mb-4">
            @if($skor >= 80) 🏆
            @elseif($skor >= 50) 👍
            @else 📚
            @endif
        </div>

        <h2 class="text-2xl font-bold text-slate-900 mb-2">Kerja Bagus, {{ $nama }}!</h2>
        <p class="text-slate-500 text-sm mb-8">Ujian telah selesai dan jawabanmu sudah dikirim ke Guru.</p>

        <!-- Kartu Skor -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white p-6 rounded-2xl shadow-lg shadow-blue-600/30 mb-8 transform transition duration-500 hover:scale-105">
            <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-1">Skor Akhir</p>
            <div class="text-6xl font-black mb-3">{{ $skor }}</div>
            <div class="flex justify-center items-center space-x-2 text-sm text-blue-50 bg-white/20 rounded-full py-1.5 px-4 inline-flex">
                <span>Benar: {{ $benar }}</span>
                <span>•</span>
                <span>Total: {{ $total }} Soal</span>
            </div>
        </div>

        <a href="{{ url('/') }}" class="inline-block w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl font-semibold transition-colors">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>