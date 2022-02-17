<?php

namespace Barryvdh\TranslationManager\Console;

class FindCommand extends Command
{
    protected $name        = 'translations:find';
    protected $description = 'Find translations in php/twig files';

    public function handle(): void
    {
        $counter = $this->manager->findTranslations();

        $this->info("Done importing, processed {$counter} items!");
    }
}
