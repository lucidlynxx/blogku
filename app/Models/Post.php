<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'status',
        'user_id',
        'meta_title',
        'meta_description'
    ];

    protected $casts = ['updated_at' => 'datetime'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function shortContent($words = 30): string
    {
        return Str::words(strip_tags($this->content), $words);
    }

    public function getFormattedDate()
    {
        return $this->updated_at->format('F jS Y');
    }

    public function getImage()
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return '/storage/' . $this->image;
    }

    public function humanReadTime(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                $words = Str::wordCount(strip_tags($attributes['content']));
                $minutes = ceil($words / 200);

                return $minutes . ' ' . str('min')->plural($minutes) . ', '
                    .  $words . ' ' . str('words')->plural($words);
            }
        );
    }
}
