<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'aspiration_id',
        'user_id',
        'message',
        'sender_type',
    ];

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
