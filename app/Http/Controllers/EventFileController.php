<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventFileController extends Controller
{
    /**
     * Upload a single document for an event.
     */
    public function uploadEventDocuments(Request $request, Event $event)
    {
        // (A) First, validate exactly one file + its metadata.
        //     We expect arrays (documents[], file_names[], descriptions[]),
        //     but we will only process index 0 of each.
        $validated = $request->validate([
            'documents'      => 'required|array|min:1',
            'documents.0'    => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
            'file_names'     => 'required|array|min:1',
            'file_names.0'   => 'required|string|max:255',
            'descriptions'   => 'required|array|min:1',
            'descriptions.0' => 'required|string|max:255',
            'visibility'     => ['required', Rule::in(['public', 'approved_only'])],
        ], [
            'documents.required'      => 'Please select a file to upload.',
            'documents.0.mimes'       => 'Only PDF, Word, and image files are allowed.',
            'file_names.0.required'   => 'Please enter a display name for the file.',
            'descriptions.0.required' => 'Please enter a description for the file.',
        ]);

        // (B) Extra “sanity” check: make sure we really do have at least one file & one name & one description.
        $fileArrayCount        = count($request->file('documents'));
        $fileNameArrayCount    = count($request->input('file_names', []));
        $descriptionArrayCount = count($request->input('descriptions', []));

        if ($fileArrayCount < 1
            || $fileNameArrayCount < 1
            || $descriptionArrayCount < 1
        ) {
            return back()
                ->with('error', 'Please upload exactly one file and its metadata.')
                ->withInput()
                ->with('active_tab', 'upload-center');
        }

        // (C) Grab only the first elements of each array:
        $document    = $request->file('documents')[0];
        $displayName = $request->input('file_names')[0];
        $descText    = $request->input('descriptions')[0];
        $visibility  = $request->input('visibility');

        try {
            // (D) Check for a PHP‐level upload error:
            if (! $document->isValid()) {
                throw new \Exception('File upload error: ' . $document->getErrorMessage());
            }

            // (E) Build a “safe” filename from the user’s display name + original extension:
            $originalExtension = $document->getClientOriginalExtension();
            $safeBaseName      = $this->sanitizeFilename($displayName);
            $safeName          = $safeBaseName . '.' . $originalExtension;

            // (F) Store on the “public” disk under event-documents/
            //     This returns something like "event-documents/your-file.pdf"
            $storedPath = Storage::disk('public')
                ->putFileAs('event-documents', $document, $safeName);

            if (! $storedPath) {
                throw new \Exception('Failed to store the file "' . $safeName . '".');
            }

            // (G) Save a single record in the database:
            $fileModel = EventFile::create([
                'event_id'    => $event->id,
                'file_name'   => $safeName,
                'file_url'    => $storedPath,
                'description' => $descText,
                'visibility'  => $visibility,
            ]);

            // (H) Redirect back to the event page with success:
            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Document uploaded successfully.')
                ->with('active_tab', 'upload-center');
        }
        catch (\Exception $e) {
            // (I) Log the error and send a friendly message back:
            Log::error('Event file upload failed: ' . $e->getMessage(), [
                'exception' => $e,
                'event_id'  => $event->id,
                'stack'     => $e->getTraceAsString(),
            ]);

            return back()
                ->with('error', 'Failed to upload file: ' . $e->getMessage())
                ->withInput()
                ->with('active_tab', 'upload-center');
        }
    }

    /**
     * Delete an event file.
     */
    public function destroy(EventFile $eventFile)
    {
        $event = $eventFile->event;

        if (auth()->id() !== $event->organizer_id) {
            return back()->with('error', 'You do not have permission to delete this file.');
        }

        // Delete from disk if it exists
        if (Storage::disk('public')->exists($eventFile->file_url)) {
            Storage::disk('public')->delete($eventFile->file_url);
        }

        // Delete the DB record
        $eventFile->delete();

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'File deleted successfully.')
            ->with('active_tab', 'upload-center');
    }

    /**
     * Remove spaces / special characters from a filename.
     */
    private function sanitizeFilename(string $filename): string
    {
        $filename = basename($filename);
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        // Replace any non‐alphanumeric or dash or underscore with underscore
        $filename = preg_replace('/[^a-zA-Z0-9-_]/', '_', $filename);
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = trim($filename, '_');

        if (empty($filename)) {
            $filename = 'file_' . time();
        }

        // Truncate if it’s too long
        if (strlen($filename) > 200) {
            $filename = substr($filename, 0, 200);
            $filename = rtrim($filename, '_');
        }

        return $filename;
    }
}