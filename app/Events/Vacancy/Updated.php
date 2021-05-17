<?php

namespace App\Events\Vacancy;

use App\Models\Vacancy;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class Updated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vacancy;

    /**
     * Create a new event instance.
     *
     * @param array $counts
     * @return void
     */
    public function __construct(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
    }


}
