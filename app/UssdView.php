<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UssdView extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_menu' => 'boolean'
    ];

    public function nextView()
    {
        return $this->belongsTo(static::class, 'next_view_id');
    }

    public function previousView()
    {
        return $this->belongsTo(static::class, 'previous_view_id');
    }

}
