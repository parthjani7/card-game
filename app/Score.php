<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $guarded = [];

    protected $casts = [
        'generated_cards' => 'array',
        'user_cards' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
