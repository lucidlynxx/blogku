<?php

namespace App\Observers;

use App\Models\TextWidget;
use Illuminate\Support\Facades\Storage;

class TextWidgetObserver
{
    /**
     * Handle the TextWidget "created" event.
     */
    public function created(TextWidget $textWidget): void
    {
        //
    }

    /**
     * Handle the TextWidget "updated" event.
     */
    public function updated(TextWidget $textWidget): void
    {
        if ($textWidget->isDirty('image') || is_null($textWidget->image)) {
            if (!is_null($textWidget->getOriginal('image'))) {
                Storage::disk('public')->delete($textWidget->getOriginal('image'));
            }
        }
    }

    /**
     * Handle the TextWidget "deleted" event.
     */
    public function deleted(TextWidget $textWidget): void
    {
        if (!is_null($textWidget->image)) {
            Storage::disk('public')->delete($textWidget->image);
        }
    }

    /**
     * Handle the TextWidget "restored" event.
     */
    public function restored(TextWidget $textWidget): void
    {
        //
    }

    /**
     * Handle the TextWidget "force deleted" event.
     */
    public function forceDeleted(TextWidget $textWidget): void
    {
        //
    }
}
