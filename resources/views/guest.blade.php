<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RembugWeb - Kolaborasi Warga</title>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-in-out;
        }
        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }
        .slide-left {
            transition: all 1s ease;
        }
        .slide-left.scroll {
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-white relative">

    <section id="slide-login" class="h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">🔐 Masuk ke RembugWeb</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block font-semibold mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-semibold mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox">
                        <span class="ml-2 text-sm">Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa Sandi?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Masuk</button>
            </form>
            <p class="mt-4 text-center text-sm">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
            </p>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-green-100 to-green-200 fade-in">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-6">💡 Ide & Diskusi</h2>
            <p class="text-lg text-gray-700">Bagikan dan diskusikan ide-ide inovatif untuk desa!</p>
        </div>
    </section>


    <section class="py-20 bg-gradient-to-r from-blue-100 to-blue-200 fade-in">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-6">🚀 Proyek</h2>
            <p class="text-lg text-gray-700">Kolaborasikan proyek desa dengan warga & komunitas.</p>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-yellow-100 to-yellow-200 fade-in">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-6">🛍️ UMKM</h2>
            <p class="text-lg text-gray-700">Dukung dan promosikan UMKM desa kamu!</p>
        </div>
    </section>
</div>
</script>


</body>
</div>

    <script>
        window.addEventListener('scroll', () => {
            const hero = document.getElementById('hero-container');
            if (window.scrollY > 50) {
                hero.classList.add('scroll');
            }

            document.querySelectorAll('.fade-up').forEach((el) => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('show');
                }
            });
        });
    </script>
</body>
</html>
