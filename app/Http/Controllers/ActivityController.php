<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    // Aktivitas user pribadi (dipakai di /profile/activity)
    public function userActivity(Request $request)
    {
        $user = auth()->user();
        $type = $request->query('type');

        $query = Activity::where('user_id', $user->id)->latest();

        if ($type) {
            $query->where(function ($q) use ($type) {
                $q->where('action', 'like', "%{$type}%")
                  ->orWhere('subject_type', 'like', "%{$type}%");
            });
        }

        $activities = $query->paginate(10);

        return view('profile.activity', compact('activities', 'type'));
    }

    // Aktivitas semua user (hanya untuk admin)
    public function adminIndex(Request $request)
    {
        $this->middleware('is_admin'); // Pastikan hanya admin

        $search = $request->query('search');

        $query = Activity::with('user')->latest();

        if ($search) {
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
        }

        $activities = $query->paginate(20);

        return view('admin.activities.index', compact('activities', 'search'));
    }
}
