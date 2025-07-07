<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectItem;
use App\Models\ItemContribution;
use Illuminate\Support\Facades\Auth;

class ItemContributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $itemId)
    {
        $item = ProjectItem::findOrFail($itemId);

        // Cek apakah user sudah berkontribusi sebelumnya
        $existing = ItemContribution::where('project_item_id', $itemId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$existing) {
            ItemContribution::create([
                'project_item_id' => $itemId,
                'user_id'         => Auth::id(),
            ]);

            // Jika kamu ingin menandai item tersedia jika minimal satu kontribusi ada
            $item->is_available = true;
            $item->save();
        }

        return redirect()->back()->with('success', 'Kontribusi berhasil dikirim.');
    }

    public function destroy($itemId)
    {
        $contribution = ItemContribution::where('project_item_id', $itemId)
            ->where('user_id', Auth::id())
            ->first();

        if ($contribution) {
            $contribution->delete();

            // Cek apakah masih ada kontribusi tersisa, kalau tidak tandai item tidak tersedia
            $remaining = ItemContribution::where('project_item_id', $itemId)->count();
            if ($remaining === 0) {
                $item = ProjectItem::find($itemId);
                if ($item) {
                    $item->is_available = false;
                    $item->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Kontribusi dibatalkan.');
    }
}
