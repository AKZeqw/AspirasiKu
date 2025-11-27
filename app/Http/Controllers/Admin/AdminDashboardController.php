<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total' => Aspiration::count(),
            'submitted' => Aspiration::where('status', 'submitted')->count(),
            'in_progress' => Aspiration::whereIn('status', ['under_review', 'in_progress'])->count(),
            'completed' => Aspiration::where('status', 'completed')->count(),
        ];

        $recent = Aspiration::with(['user', 'category'])
            ->where('status', '!=', 'draft')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
