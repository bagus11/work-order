<?php

namespace App\Http\Controllers;

use App\Models\FileSharingLog;
use App\Models\FileSharingModel;
use App\Models\MasterDepartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileSharingController extends Controller
{
    function index() {
        return  view('file_sharing/file_sharing-index');
    }

    function getFileSharing(Request $request) {
         $query = FileSharingModel::with([
        'userRelation',
        'departmentRelation',
    ]);

    // 🔹 Jika super user (NIK 100162) atau punya permission
    if (auth()->user()->nik == 100162 || auth()->user()->hasPermissionTo('get-all-file_sharing')) {
        // Bisa lihat semua + boleh filter
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('user_filter')) {
            $query->where('user_id', $request->user_filter);
        }
    } 
    // 🔹 Kalau user biasa, cuma lihat file dia sendiri
    else {
        $query->where('user_id', auth()->user()->id);
    }

    $data = $query->orderBy('created_at', 'desc')->get();

        return json_encode([
            'data'  => $data
        ]);
    }
    function addFileSharing(Request $request) {
           $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'attachment' => 'required|file|max:2048',
            'description' => 'nullable|string',
        ]);
        $message = 'Failed to store data, please contact ICT Developers';
        $department = MasterDepartement::find($request->department_id);
        $initial = strtoupper($department->initial ?? substr($department->name, 0, 3));
        // path tujuan
        $folderPath = "file_sharing/{$initial}";

      
        $file = $request->file('attachment');
        $extension = $file->getClientOriginalExtension();
        $filename = now()->format('YmdHis') . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($folderPath, $filename, 'public');

        $insert = FileSharingModel::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            'department_id' => $request->department_id,
            'attachment' => $path,
            'description' => $request->description,
        ]);
        if($insert){
            $message = "Successfully store data";
        }
        return response()->json([
            'success' => true,
            'message'   =>$message
        ]);
    }
    function getFileHistory(Request $request) {
        $data = FileSharingLog::with([
            'userRelation'
        ])->where('file_id', $request->id)->get();

        return json_encode([
            'data'  => $data
        ]);

    }
      public function fileSharingUpdate(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:file_sharing_models,id',
            'remark' => 'nullable|string|max:500',
            'attachment_update' => 'nullable|file|max:10240', // max 10MB
        ]);

        // Ambil record utama
        $file = FileSharingModel::find($request->edit_id);

        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Simpan file lama untuk log
        $attachmentBefore = $file->attachment;

        // Upload file baru jika ada
        $newAttachmentPath = null;
        if ($request->hasFile('attachment_update')) {
            $fileUpload = $request->file('attachment_update');

            // Ambil nama department dari record
            $department = MasterDepartement::find($file->department_id)->value('INITIAL');
            $folderPath = 'file_sharing/' . strtoupper($department);

           $extension = $fileUpload->getClientOriginalExtension();
            $filename = now()->format('YmdHis') . '_' . uniqid() . '.' . $extension;
            $path = $fileUpload->storeAs($folderPath, $filename, 'public');

            $newAttachmentPath = $path;

            // Hapus file lama kalau perlu
            // if ($attachmentBefore && Storage::disk('public')->exists($attachmentBefore)) {
            //     Storage::disk('public')->delete($attachmentBefore);
            // }

            // Update kolom attachment di tabel utama
            $file->update([
                'attachment' => $newAttachmentPath,
            ]);
        }
      

        // Tambah log baru
        FileSharingLog::create([
            'file_id' => $file->id,
            'created_by' => auth()->user()->id,
            'remark' => $request->remark,
            'attachment' => $newAttachmentPath ?? $attachmentBefore,
            'attachment_before' => $attachmentBefore,
        ]);
        $data = FileSharingLog::with([
            'userRelation'
        ])->where('file_id', $request->edit_id)->get();
        return response()->json([
            'message' => 'File updated successfully!',
            'data' => $data,
        ]);
    }
}
