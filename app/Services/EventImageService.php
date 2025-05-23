<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EventImageService
{
    protected string $disk   = 'public';
    protected string $folder = 'events';

    /**
     * Store a new image (deleting the old one first).
     */
    public function upload(Event $event, ?UploadedFile $file): void
    {
        if (! $file) {
            return;
        }

        // delete old
        if ($event->image) {
            Storage::disk($this->disk)->delete($event->image);
        }

        // store new
        $path = $file->store($this->folder, $this->disk);
        $event->image = $path;
        $event->save();
    }

    /**
     * Delete the image from disk (if any).
     */
    public function delete(Event $event): void
    {
        if ($event->image) {
            Storage::disk($this->disk)->delete($event->image);
        }
    }
}
