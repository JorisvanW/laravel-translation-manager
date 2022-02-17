<?php

namespace Barryvdh\TranslationManager\Console;

use Symfony\Component\Console\Input\InputArgument;

class ExportCommand extends Command
{
    protected $name        = 'translations:export';
    protected $description = 'Export translations to PHP files';

    public function handle(): void
    {
        $group = $this->argument('group');

        $this->manager->exportTranslations($group);

        $this->info("Done writing language files for " . ($group === '*' ? 'ALL groups' : $group . " group"));
    }

    protected function getArguments(): array
    {
        return [
            ['group', InputArgument::REQUIRED, 'The group to export (`*` for all).'],
        ];
    }
}
