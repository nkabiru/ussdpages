<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UssdSession extends Model
{
    protected $guarded = [];

    public function currentView()
    {
        return $this->belongsTo(UssdView::class, 'current_view_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
