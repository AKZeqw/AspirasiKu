<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsType;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with(['author', 'type'])
            ->latest()
            ->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newsTypes = NewsType::orderBy('name')->get();
        return view('admin.news.form', compact('newsTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'news_type_id' => 'required|exists:news_types,id',
            'content'      => 'required|string',
            'excerpt'      => 'nullable|string',
            'cover_image'  => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean', // akan dioverride
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        $action = $request->input('action', 'draft');

        if ($action === 'publish') {
            $data['is_published'] = true;
            $data['published_at'] = now();
        } else {
            $data['is_published'] = false;
            $data['published_at'] = null;
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', $action === 'publish'
                ? 'Berita berhasil dipublikasikan.'
                : 'Berita disimpan sebagai draft.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $newsTypes = NewsType::orderBy('name')->get();
        return view('admin.news.form', compact('news', 'newsTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, News $news)
{
    $data = $request->validate([
        'title'        => 'required|string|max:255',
        'news_type_id' => 'required|exists:news_types,id',
        'content'      => 'required|string',
        'excerpt'      => 'nullable|string',
        'cover_image'  => 'nullable|image|max:20480',
    ]);

    if ($request->hasFile('cover_image')) {
        $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
    }

    $action = $request->input('action', 'draft');

    if ($action === 'publish') {
        $data['is_published'] = true;
        if (! $news->published_at) {
            $data['published_at'] = now();
        }
    } else {
        $data['is_published'] = false;
        $data['published_at'] = null;
    }

    $news->update($data);

    return redirect()->route('admin.news.index')
        ->with('success', $action === 'publish'
            ? 'Berita berhasil dipublikasikan.'
            : 'Berita disimpan sebagai draft.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }
}
