<?php

namespace App\Jobs;

use App\Item;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateItemInDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $attributes;
    public $user;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @param  array  $attributes
     */
    public function __construct(User $user, array $attributes)
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
        $this->user->items()->create([
            'name' => $this->attributes['name'],
            'quantity' => $this->attributes['quantity']
        ]);
    }
}
