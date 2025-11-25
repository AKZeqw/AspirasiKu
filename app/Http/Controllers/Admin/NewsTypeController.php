<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsType;
use Illuminate\Http\Request;

class NewsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = NewsType::withCount('news')->orderBy('name')->get();
        return view('admin.news_types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news_types.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        NewsType::create($data);

        return redirect()->route('admin.news-types.index')
            ->with('success', 'Tipe berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsType $newsType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsType $newsType)
    {
        return view('admin.news_types.form', compact('newsType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsType $newsType)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $newsType->update($data);

        return redirect()->route('admin.news-types.index')
            ->with('success', 'Tipe berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsType $newsType)
    {
        $newsType->delete();
        return back()->with('success', 'Tipe berita berhasil dihapus.');
    }
}
