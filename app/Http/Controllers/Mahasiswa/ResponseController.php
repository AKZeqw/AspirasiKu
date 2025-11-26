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
        // Cek apakah aspirasi milik user ini
        if ($aspiration->user_id !== auth()->id()) {
            abort(403);
        }

        // Proteksi: Tidak bisa balas jika closed/rejected
        if (in_array($aspiration->status, ['completed', 'rejected'])) {
            return back()->with('error', 'Tidak dapat mengirim tanggapan pada aspirasi yang sudah selesai atau ditolak.');
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
        // 1. Cek Pemilik
        if ($response->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. PROTEKSI KHUSUS MAHASISWA: Cek Status Aspirasi
        $aspiration = $response->aspiration; 
        if (in_array($aspiration->status, ['completed', 'rejected'])) {
            return back()->with('error', 'Tanggapan tidak dapat diedit karena status aspirasi sudah Selesai atau Ditolak.');
        }

        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
            'delete_attachments' => 'nullable|array',
            'delete_attachments.*' => 'exists:attachments,id',
        ]);

        // 3. Update Pesan
        $response->update([
            'message' => $request->message
        ]);

        // 4. Hapus Lampiran yang dipilih
        if ($request->filled('delete_attachments')) {
            $attachmentsToDelete = Attachment::whereIn('id', $request->delete_attachments)
                ->where('attachable_id', $response->id) // Pastikan milik response ini
                ->where('attachable_type', Response::class)
                ->get();

            foreach ($attachmentsToDelete as $attachment) {
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                $attachment->delete();
            }
        }

        // 5. Upload Lampiran Baru
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

        return back()->with('success', 'Balasan berhasil diperbarui!');
    }

    public function destroy(Response $response)
    {
        if ($response->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Proteksi Hapus: Cek Status
        $aspiration = $response->aspiration;
        if (in_array($aspiration->status, ['completed', 'rejected'])) {
            return back()->with('error', 'Tanggapan tidak dapat dihapus karena status aspirasi sudah Selesai atau Ditolak.');
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