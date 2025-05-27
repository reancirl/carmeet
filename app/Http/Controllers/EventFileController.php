<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventFileController extends Controller
{
    /**
     * Upload documents for an event.
     */
    public function uploadEventDocuments(Request $request, Event $event)
    {
        $request->validate([
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'descriptions' => 'required|array',
            'descriptions.*' => 'required|string|max:255',
            'visibility' => ['required', Rule::in(['public', 'approved_only'])],
        ]);

        $uploadedFiles = [];

        foreach ($request->file('documents') as $index => $document) {
            $path = $document->store('event-documents', 'public');
            $fileName = $document->getClientOriginalName();

            $file = EventFile::create([
                'event_id' => $event->id,
                'file_name' => $fileName,
                'file_url' => $path,
                'description' => $request->input('descriptions')[$index] ?? null,
                'visibility' => $request->input('visibility')
            ]);

            $uploadedFiles[] = $file;
        }

        return redirect()->route('events.show', $event)->with('success', 'Event documents uploaded successfully.')->with('active_tab', 'upload-center');
    }

    /**
     * Delete an event file.
     */
    public function destroy(EventFile $eventFile)
    {
        // Check if user has permission to delete this file
        $event = $eventFile->event;
        if (auth()->id() !== $event->organizer_id) {
            return back()->with('error', 'You do not have permission to delete this file.');
        }

        // Delete the file from storage
        if (Storage::disk('public')->exists($eventFile->file_url)) {
            Storage::disk('public')->delete($eventFile->file_url);
        }

        // Delete the record
        $eventFile->delete();

        return redirect()->route('events.show', $event)->with('success', 'File deleted successfully.')->with('active_tab', 'upload-center');
    }
}
