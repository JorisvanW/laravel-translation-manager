<?php

namespace Barryvdh\TranslationManager\Events;

use Illuminate\Queue\SerializesModels;

class Published
{
    use SerializesModels;

    /**
     * The group of translations that was published.
     */
    public ?string $group;

    public function __construct(?string $group = null)
    {
        $this->group = $group;
    }
}
