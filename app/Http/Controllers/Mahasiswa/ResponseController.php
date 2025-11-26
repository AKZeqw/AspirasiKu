<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Response;
use App\Models\Aspiration;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResponseController extends Controller
{
    public function store(Request $request, Aspiration $aspiration)
    {
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $response = Response::create([
            'aspiration_id' => $aspiration->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'mahasiswa',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/responses', 'public');
                
                Attachment::create([
                    'attachable_id' => $response->id,
                    'attachable_type' => Response::class,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    public function update(Request $request, Response $response)
    {
        if ($response->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $response->update([
            'message' => $request->message
        ]);

        return back()->with('success', 'Balasan berhasil diperbarui!');
    }

    public function destroy(Response $response)
    {
        if ($response->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        foreach($response->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            $attachment->delete();
        }

        $response->delete();
        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}