<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicAspirationController extends Controller
{
    /**
     * Display a listing of public aspirations.
     */
    public function index(Request $request)
    {
        $query = Aspiration::with(['user', 'category'])
            ->where('status', 'completed');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $aspirations = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('public.aspirations.index', compact('aspirations', 'categories'));
    }

    /**
     * Display the specified public aspiration.
     */
    public function show(Aspiration $aspiration)
    {
        if ($aspiration->status !== 'completed') {
            abort(404);
        }

        $aspiration->load(['user', 'category', 'responses.user', 'responses.attachments', 'attachments']);
        return view('public.aspirations.show', compact('aspiration'));
    }
}
