<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkStats extends Model
{
    use HasFactory;

    protected $table = 'link_stats';

    protected $fillable = [
        'user_id',
        'number_of_views',
        'number_of_links'
    ];

    protected $attributes = [
        'number_of_views' => 0,
        'number_of_links' => 0
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
