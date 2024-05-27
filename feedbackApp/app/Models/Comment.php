<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'feedback_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id');
    }
}
