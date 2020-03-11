<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $guarded = [];

    protected $casts = [
        'generated_cards' => 'array',
        'user_cards' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
