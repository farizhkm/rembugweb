<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RembugWeb - Kolaborasi Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-200 via-white to-green-100 min-h-screen flex items-center justify-center">

    <div class="text-center bg-white bg-opacity-80 backdrop-blur-sm p-10 rounded-xl shadow-xl max-w-lg w-full">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">RembugWeb</h1>
        <p class="text-gray-600 text-lg mb-6">Tempat Kolaborasi & Solusi Masyarakat</p>

        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Sudah punya akun</a>
            <a href="{{ route('register') }}" class="inline-block border border-gray-400 px-6 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Belum punya akun</a>
        </div>
    </div>

</body>
</html>
