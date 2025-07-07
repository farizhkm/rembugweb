<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">Rembug</span>
                    <span class="text-2xl font-bold text-green-600">Web</span>
                </a>
                <p class="text-gray-500 mt-2">Platform kolaborasi masyarakat dan UMKM</p>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:grid-cols-3">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Navigasi</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-900">Beranda</a></li>
                        <li><a href="{{ route('ideas.index') }}" class="text-gray-500 hover:text-gray-900">Ide & Diskusi</a></li>
                        <li><a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-900">Proyek</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Peta</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-900">UMKM</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Tentang</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-500 hover:text-gray-900">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Kontak</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Legal</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
            <div class="flex space-x-6 md:order-2">
                <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-linkedin fa-lg"></i></a>
            </div>
            <p class="mt-8 text-center text-gray-500 md:mt-0 md:text-left">
                © {{ date('Y') }} RembugWeb. All rights reserved.
            </p>
        </div>
    </div>
</footer>
