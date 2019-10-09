<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RemoveItemFromDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $attributes;
    private $user;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @param $attributes
     */
    public function __construct(User $user, $attributes)
    {
        $this->user = $user;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $item = $this->user->items()->where('name', $this->attributes['name'])->firstOrFail();

        $item->quantity -= $this->attributes['quantity'];
        $item->save();
    }
}
