<?php

namespace Barryvdh\TranslationManager\Console;

class ResetCommand extends Command
{
    protected $name        = 'translations:reset';
    protected $description = 'Delete all translations from the database';

    public function handle(): void
    {
        $this->manager->truncateTranslations();

        $this->info("All translations are deleted");
    }
}
