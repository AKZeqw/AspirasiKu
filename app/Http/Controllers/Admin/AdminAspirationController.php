<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class AdminAspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Aspiration::with(['user', 'category'])
            ->where('status', '!=', 'draft');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $aspirations = $query->latest()->paginate(15);
        
        return view('admin.aspirations.index', compact('aspirations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspiration $aspiration)
    {
        $aspiration->load(['user', 'category', 'responses.user', 'responses.attachments', 'attachments']);
        return view('admin.aspirations.show', compact('aspiration'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Aspiration $aspiration)
    {
        $request->validate([
            'status' => 'required|in:submitted,under_review,in_progress,completed,rejected',
        ]);

        $aspiration->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diupdate!');
    }
}
