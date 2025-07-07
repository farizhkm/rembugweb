<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Idea;
use App\Models\Product;
use App\Models\Umkm;

class MapController extends Controller
{
    /**
     * Tampilkan halaman peta kolaborasi berisi ide, produk UMKM, dan proyek.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua ide, UMKM, dan proyek yang memiliki koordinat
        $ideas = Idea::whereNotNull('lat')->whereNotNull('lng')->get();
        $umkms = Umkm::whereNotNull('lat')->whereNotNull('lng')->get();
        $projects = Project::whereNotNull('lat')->whereNotNull('lng')->get();

        // Hitung jumlah masing-masing
        $ideaCount = $ideas->count();
        $umkmCount = $umkms->count();
        $projectCount = $projects->count();

        // Kirim ke view
        return view('map.index', compact(
            'ideas', 'umkms', 'projects',
            'ideaCount', 'umkmCount', 'projectCount'
        ));
    }
}
