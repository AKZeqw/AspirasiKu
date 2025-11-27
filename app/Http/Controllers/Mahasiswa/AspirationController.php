<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aspirations = Aspiration::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('mahasiswa.aspirations.index', compact('aspirations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('mahasiswa.aspirations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // PERBAIKAN 1: Hapus 'is_anonymous' => 'boolean' dari validasi
        // Checkbox HTML mengirim "on" jika dicentang, yang akan membuat validasi 'boolean' gagal.
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $aspiration = Aspiration::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            // PERBAIKAN 2: Gunakan $request->boolean()
            // Ini otomatis mengubah "on", "1", true menjadi boolean true. Jika kosong jadi false.
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => $request->action === 'submit' ? 'submitted' : 'draft',
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/aspirations', 'public');
                
                Attachment::create([
                    'attachable_id' => $aspiration->id,
                    'attachable_type' => Aspiration::class,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        $message = $request->action === 'submit' ? 'Aspirasi berhasil disubmit!' : 'Aspirasi berhasil disimpan sebagai draft!';
        return redirect()->route('mahasiswa.aspirations.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspiration $aspiration)
    {
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        $aspiration->load(['category', 'responses.user', 'responses.attachments', 'attachments']);
        return view('mahasiswa.aspirations.show', compact('aspiration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspiration $aspiration)
    {
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($aspiration->status, ['draft', 'submitted'])) {
            return back()->with('error', 'Aspirasi tidak bisa diedit!');
        }

        $categories = Category::all();
        return view('mahasiswa.aspirations.edit', compact('aspiration', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspiration $aspiration)
    {
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        // PERBAIKAN 3: Hapus validasi boolean di update juga
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $aspiration->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            // PERBAIKAN 4: Gunakan boolean() di update juga
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => $request->action === 'submit' ? 'submitted' : 'draft',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/aspirations', 'public');
                
                Attachment::create([
                    'attachable_id' => $aspiration->id,
                    'attachable_type' => Aspiration::class,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('mahasiswa.aspirations.show', $aspiration)->with('success', 'Aspirasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration)
    {
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        $aspiration->delete();
        return redirect()->route('mahasiswa.aspirations.index')->with('success', 'Aspirasi berhasil dihapus!');
    }
}