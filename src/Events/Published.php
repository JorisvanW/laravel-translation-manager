<?php

namespace Barryvdh\TranslationManager\Events;

use Illuminate\Queue\SerializesModels;

class Published
{
    use SerializesModels;

    /**
     * The published group.
     *
     * @var string|null
     */
    public $group;

    /**
     * Create a new event instance.
     *
     * @param string|null $group
     */
    public function __construct($group = null)
    {
        $this->group = $group;
    }
}
