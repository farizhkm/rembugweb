@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 bg-white rounded-lg shadow-sm mt-6">
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-4">Tentang RembugWeb</h1>

    <p class="text-gray-700 text-lg mb-6 leading-relaxed text-justify">
        <strong>RembugWeb</strong> adalah platform kolaborasi dan partisipasi masyarakat berbasis web yang bertujuan untuk mempermudah warga dalam menyampaikan ide, membentuk proyek bersama, dan mempromosikan produk UMKM secara digital.
    </p>

    <div class="grid md:grid-cols-3 gap-6 mb-10">
        <div class="bg-blue-50 p-4 rounded-md shadow text-center">
            <i class="fas fa-lightbulb text-3xl text-blue-600 mb-2"></i>
            <h3 class="font-semibold text-lg mb-1">Ide & Diskusi</h3>
            <p class="text-sm text-gray-600">Tempat warga menyampaikan gagasan dan berdiskusi demi kemajuan lingkungan.</p>
        </div>
        <div class="bg-green-50 p-4 rounded-md shadow text-center">
            <i class="fas fa-tools text-3xl text-green-600 mb-2"></i>
            <h3 class="font-semibold text-lg mb-1">Proyek Kolaboratif</h3>
            <p class="text-sm text-gray-600">Inisiasi proyek gotong-royong dan kebutuhan alat/bahan yang bisa dibantu warga sekitar.</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-md shadow text-center">
            <i class="fas fa-store text-3xl text-yellow-600 mb-2"></i>
            <h3 class="font-semibold text-lg mb-1">Produk UMKM</h3>
            <p class="text-sm text-gray-600">Media promosi pelaku usaha kecil menengah agar produknya lebih dikenal masyarakat.</p>
        </div>
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Visi</h2>
    <p class="mb-6 text-gray-700">
        Menjadi platform digital kolaboratif untuk membangun masyarakat yang lebih partisipatif, kreatif, dan produktif.
    </p>

    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Misi</h2>
    <ul class="list-disc pl-6 text-gray-700 space-y-1">
        <li>Memfasilitasi warga menyampaikan ide secara terbuka dan konstruktif.</li>
        <li>Mendorong gotong-royong dalam mewujudkan proyek bersama.</li>
        <li>Mendukung pelaku UMKM dalam pemasaran digital.</li>
        <li>Menyediakan fitur interaktif yang ramah pengguna dan transparan.</li>
    </ul>
</div>
@endsection
