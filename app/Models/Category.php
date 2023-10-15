<?php

namespace App\Models;

use App\Models\FeedBack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "body"
    ];

    public function feedback()
    {
        return $this->hasMany(FeedBack::class);
    }
}
