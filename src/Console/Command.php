<?php

namespace Barryvdh\TranslationManager\Console;

use Barryvdh\TranslationManager\Manager;
use Illuminate\Console\Command as IlluminateCommand;

abstract class Command extends IlluminateCommand
{
    protected Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }
}
