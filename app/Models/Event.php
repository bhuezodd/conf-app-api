<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'image',
        'start_date',
        'end_date',
        'address',
        'user_id',
        'category_id',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    } 

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
