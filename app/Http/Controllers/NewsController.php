<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsType;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('type')
            ->where('is_published', true);

        if ($request->filled('type')) {
            $query->where('news_type_id', $request->type);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }

        $news = $query->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $types = NewsType::orderBy('name')->get();

        return view('news.index', compact('news', 'types'));
    }

    public function show(News $news)
    {
        if (! $news->is_published) {
            abort(404);
        }

        return view('news.show', compact('news'));
    }
}
