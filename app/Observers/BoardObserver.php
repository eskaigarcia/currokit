<?php

namespace App\Observers;

use App\Models\Board;

class BoardObserver
{
    public function deleted(Board $board): void
    {
        $board->collaborators()->detach();

        $board->companyInstances()->each(function ($instance) {
            $instance->offers()->delete();
            $instance->delete();
        });
    }
}
