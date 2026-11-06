<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru - SmartQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm bg-white p-8 rounded-3xl shadow-xl border border-slate-100 relative">
        
        <!-- BAGIAN LOGIN -->
        <div id="login-section">
            <h2 class="text-2xl font-extrabold text-slate-900 text-center mb-8">Login Guru</h2>
            
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded-xl text-sm text-center font-medium border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->has('login_error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl text-sm text-center font-medium">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form action="{{ url('/login-guru') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm">
                </div>
                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-colors shadow-lg shadow-indigo-600/30">
                    Masuk
                </button>
            </form>
            <div class="mt-6 flex flex-col items-center space-y-4">
                <button type="button" onclick="toggleForm('register')" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Buat Akun Baru</button>
                <a href="{{ url('/') }}" class="text-sm text-slate-500 hover:text-slate-800 transition-colors">&larr; Kembali ke Beranda</a>
            </div>
        </div>

        <!-- BAGIAN BUAT AKUN -->
        <div id="register-section" class="hidden">
            <h2 class="text-2xl font-extrabold text-slate-900 text-center mb-8">Buat Akun</h2>
            
            @if($errors->any() && !$errors->has('login_error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl text-sm text-center font-medium">
                    Cek kembali: Username mungkin sudah dipakai atau sandi kurang dari 4 karakter.
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        toggleForm('register');
                    });
                </script>
            @endif

            <form action="{{ url('/register-guru') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Ditambahkan input nama lengkap agar sesuai dengan database -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" placeholder="Contoh: Budi Santoso, S.Pd.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sandi (Min. 4 Karakter)</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm">
                </div>
                <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-colors shadow-lg shadow-blue-600/30 mt-2">
                    Daftar Akun
                </button>
            </form>
            <div class="mt-6 flex flex-col items-center space-y-4">
                <button type="button" onclick="toggleForm('login')" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Sudah punya akun? Masuk</button>
                <a href="{{ url('/') }}" class="text-sm text-slate-500 hover:text-slate-800 transition-colors">&larr; Kembali ke Beranda</a>
            </div>
        </div>

    </div>

    <!-- Skrip untuk pergantian formulir -->
    <script>
        function toggleForm(formType) {
            const loginSection = document.getElementById('login-section');
            const registerSection = document.getElementById('register-section');

            if (formType === 'register') {
                loginSection.classList.add('hidden');
                registerSection.classList.remove('hidden');
            } else {
                registerSection.classList.add('hidden');
                loginSection.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>