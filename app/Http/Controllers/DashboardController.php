<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Project;
use App\Models\UMKM;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the latest data for each section
        $ideas = Idea::latest()->limit(3)->get();  // Fetch top 3 latest ideas
        $projects = Project::latest()->limit(3)->get();  // Fetch top 3 latest projects
        $umkms = UMKM::latest()->limit(3)->get();  // Fetch top 3 latest UMKM

        // Pass the data to the view
        return view('welcome', compact('ideas', 'projects', 'umkms')); // Ensure variables are passed here
    }
}
