<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedBack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        "category_id",
        'image',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class,"feedback_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
