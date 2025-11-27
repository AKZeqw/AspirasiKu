<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Response;
use App\Models\Aspiration;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminResponseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Aspiration $aspiration)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $response = Response::create([
            'aspiration_id' => $aspiration->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'admin',
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

        return back()->with('success', 'Tanggapan berhasil dikirim!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Response $response)
    {
        if ($response->user_id !== auth()->id()) {
            abort(403, 'Admin hanya dapat mengedit tanggapannya sendiri.');
        }

        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
            'delete_attachments' => 'nullable|array', 
            'delete_attachments.*' => 'exists:attachments,id',
        ]);

        $response->update([
            'message' => $request->message
        ]);

        if ($request->filled('delete_attachments')) {
            $attachmentsToDelete = Attachment::whereIn('id', $request->delete_attachments)
                ->where('attachable_id', $response->id)
                ->where('attachable_type', Response::class)
                ->get();

            foreach ($attachmentsToDelete as $attachment) {
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                $attachment->delete();
            }
        }

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

        return back()->with('success', 'Tanggapan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Response $response)
    {
        foreach($response->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            $attachment->delete();
        }

        $response->delete();
        return back()->with('success', 'Tanggapan berhasil dihapus!');
    }
}