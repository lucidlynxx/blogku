<?php

namespace App\Filament\Widgets;

use App\Models\PostView;
use App\Models\upvoteDownvote;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class PostOverview extends Widget
{
    protected int | string | array $columnSpan = 3;

    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'viewCount' => PostView::where('post_id', '=', $this->record->id)
                ->count(),
            'upvotes' => upvoteDownvote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', true)
                ->count(),
            'downvotes' => upvoteDownvote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', false)
                ->count()
        ];
    }

    public static function canView(): bool
    {
        if (Route::is('filament.pages.dashboard')) {
            return false;
        } else {
            return true;
        }
    }

    protected static string $view = 'filament.widgets.post-overview';
}
