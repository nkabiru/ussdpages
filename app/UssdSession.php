<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UssdSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'input_history' => 'array'
    ];

    public function currentView()
    {
        return $this->belongsTo(UssdView::class, 'current_view_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nextView()
    {
        if ($this->currentView->isLast()) {
            return $this->currentView;
        }

        $this->currentView()->associate($this->currentView->nextViews[0]);
        $this->save();

        return $this->fresh()->currentView;
    }

    public function previousView()
    {
        $this->currentView()->associate($this->currentView->previousView);
        $this->save();

        return $this->fresh()->currentView;
    }

    public function makeCurrentView(UssdView $view)
    {
        $this->currentView()->associate($view);

        return $this->save();
    }
}
