<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjakan Kuis - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold">SQ</div>
                <h1 class="text-lg font-bold text-slate-900">Halo, {{ $nama_siswa }}!</h1>
            </div>
            <!-- Tombol Keluar untuk membersihkan Session -->
            <a href="{{ url('/') }}" class="text-sm font-medium text-rose-500 hover:text-rose-700 transition-colors">Keluar Kuis</a>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-8">
        
        <div class="mb-6 border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-bold text-slate-900">{{ $kuis->judul }}</h2>
            <p class="text-sm text-slate-500 mt-1">Kode Kuis: <span class="font-mono font-bold text-blue-600">{{ $kuis->kode_kuis }}</span> | Total: {{ $daftar_soal->count() }} Soal</p>
        </div>

<!-- FORM SUDAH DIARAHKAN KE /hitung-skor -->
        <form action="{{ url('/hitung-skor') }}" method="POST" class="space-y-6">
            @csrf
            
            @foreach($daftar_soal as $index => $soal)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex gap-4 mb-4">
                    <div class="shrink-0 w-8 h-8 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold">
                        {{ $index + 1 }}
                    </div>
                    <p class="font-medium text-slate-900 pt-1">{{ $soal->pertanyaan }}</p>
                </div>
                
                <div class="ml-12 space-y-3">
                    <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="A" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-slate-700">A. {{ $soal->opsi_a }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="B" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-slate-700">B. {{ $soal->opsi_b }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="C" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-slate-700">C. {{ $soal->opsi_c }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="D" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-slate-700">D. {{ $soal->opsi_d }}</span>
                    </label>
                </div>
            </div>
            @endforeach

            <!-- UBAH TYPE JADI SUBMIT -->
            <div class="pt-4 pb-10">
                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-colors shadow-lg shadow-blue-600/30">
                    Kumpulkan Jawaban
                </button>
            </div>
        </form>

    </main>
</body>
</html>