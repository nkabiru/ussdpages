<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UssdView
 *
 * @property int $id
 * @property string $name
 * @property string $body
 * @property int|null $previous_view_id
 * @property bool $is_menu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UssdView[] $nextViews
 * @property-read int|null $next_views_count
 * @property-read \App\UssdView|null $previousView
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UssdSession[] $sessions
 * @property-read int|null $sessions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView wherePreviousViewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UssdView whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function isNotLast()
    {
        return $this->nextViews()->exists();
    }

    public function isLast()
    {
        return ! $this->isNotLast();
    }

    public function isConfirmPinView()
    {
        return $this->is(static::where('name', 'register-confirm-pin')->first());
    }

}
