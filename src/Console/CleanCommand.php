<?php

namespace Barryvdh\TranslationManager\Console;

class CleanCommand extends Command
{
    protected $name        = 'translations:clean';
    protected $description = 'Clean empty translations';

    public function handle(): void
    {
        $this->manager->cleanTranslations();

        $this->info("Done cleaning translations");
    }
}
