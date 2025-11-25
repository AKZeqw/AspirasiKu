<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'news_type_id',
        'title',
        'excerpt',
        'content',
        'cover_image',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(NewsType::class, 'news_type_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type?->name ?? '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_published ? 'Published' : 'Draft';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
