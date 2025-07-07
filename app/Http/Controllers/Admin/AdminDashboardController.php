<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Project;
use App\Models\Product;
use App\Models\Comment;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalIdeas     = Idea::count();
        $totalProjects  = Project::count();
        $totalProducts  = Product::count();
        $totalComments  = Comment::count();
        $totalUsers     = User::count();

        $ideas          = Idea::latest()->take(10)->get();
        $projects       = Project::latest()->take(10)->get();
        $products       = Product::latest()->take(10)->get();

        $recentActivities = Activity::with('user')->latest()->limit(5)->get();
        $latestUsers      = User::latest()->limit(5)->get();

        // Data grafik aktivitas per hari
        $activityChart = Activity::selectRaw("DATE(created_at) as date, COUNT(*) as total")
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalIdeas', 'totalProjects', 'totalProducts', 'totalComments', 'totalUsers',
            'ideas', 'projects', 'products',
            'recentActivities', 'latestUsers',
            'activityChart'
        ));
    }

    public function exportPdf(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Ambil aktivitas sesuai filter tanggal
    $activities = Activity::with('user')
        ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
        ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
        ->get();

    // Data statistik
    $totalIdeas     = Idea::count();
    $totalProjects  = Project::count();
    $totalProducts  = Product::count();
    $totalComments  = Comment::count();
    $totalUsers     = User::count();

    $recentActivities = Activity::with('user')->latest()->limit(5)->get();
    $latestUsers      = User::latest()->limit(5)->get();

    // Grafik aktivitas per hari
    $activityChart = Activity::selectRaw("DATE(created_at) as date, COUNT(*) as total")
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy(DB::raw("DATE(created_at)"))
        ->orderBy('date')
        ->get();

    $chartPath = public_path('images/aktivitas_chart.png'); // gambar grafik disimpan di public

    return Pdf::loadView('admin.exports.dashboard_pdf', [
        'activities'        => $activities,
        'recentActivities'  => $recentActivities,
        'latestUsers'       => $latestUsers,
        'startDate'         => $startDate,
        'endDate'           => $endDate,
        'chartPath'         => $chartPath,

        'totalIdeas'        => $totalIdeas,
        'totalProjects'     => $totalProjects,
        'totalProducts'     => $totalProducts,
        'totalComments'     => $totalComments,
        'totalUsers'        => $totalUsers,
        'activityChart'     => $activityChart
    ])->download('dashboard-aktivitas.pdf');
}

}
