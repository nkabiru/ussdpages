<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UssdView extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_menu' => 'boolean'
    ];

    public function nextViews()
    {
        return $this->hasMany(static::class, 'previous_view_id');
    }

    public function previousView()
    {
        return $this->belongsTo(static::class, 'previous_view_id');
    }

    public function sessions()
    {
        return $this->hasMany(UssdSession::class, 'current_view_id');
    }

    public function isLast()
    {
        return $this->nextViews()->doesntExist();
    }

}
