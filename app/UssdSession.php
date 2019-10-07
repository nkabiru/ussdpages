<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UssdSession
 *
 * @property int $id
 * @property string $session_id
 * @property string $phone_number
 * @property int|null $user_id
 * @property int|null $current_view_id
 * @property array|null $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UssdView|null $currentView
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereCurrentViewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdSession whereUserId($value)
 * @mixin \Eloquent
 */
class UssdSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'state' => 'array'
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
