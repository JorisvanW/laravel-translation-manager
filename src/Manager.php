<?php

namespace Barryvdh\TranslationManager;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Finder\Finder;

class Manager
{
    /** @var \Illuminate\Foundation\Application */
    protected $app;
    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;
    /** @var \Illuminate\Events\Dispatcher */
    protected $events;

    protected $config;

    public function __construct(Application $app, Filesystem $files, Dispatcher $events)
    {
        $this->app    = $app;
        $this->files  = $files;
        $this->events = $events;
        $this->config = $app['config']['translation-manager'];
    }

    public function missingKey($namespace, $group, $key)
    {
        if (!in_array($group, (is_callable($configVal = $this->config['exclude_groups']) ? $configVal() : $configVal)) && (is_callable($configVal = $this->getConfig('creating_enabled')) ? $configVal() : $configVal)) {
            Translation::firstOrCreate([
                'locale' => $this->app['config']['app.locale'],
                'group'  => $group,
                'key'    => $key,
            ]);
        }
    }

    public function importTranslations($replace = false)
    {
        if (is_callable($configVal = $this->getConfig('import_enabled')) ? $configVal() : $configVal) {
            $counter = 0;
            foreach ($this->files->directories($this->app['path.lang']) as $langPath) {
                $locale = basename($langPath);

                foreach ($this->files->allfiles($langPath) as $file) {

                    $info  = pathinfo($file);
                    $group = $info['filename'];

                    if (in_array($group, (is_callable($configVal = $this->config['exclude_groups']) ? $configVal() : $configVal))) {
                        continue;
                    }

                    $subLangPath = str_replace($langPath . DIRECTORY_SEPARATOR, "", $info['dirname']);
                    if ($subLangPath != $langPath) {
                        $group = $subLangPath . "/" . $group;
                    }

                    $translations = Lang::getLoader()->load($locale, $group);
                    if ($translations && is_array($translations)) {
                        foreach (Arr::dot($translations) as $key => $value) {
                            // process only string values
                            if (is_array($value)) {
                                continue;
                            }
                            $value       = (string)$value;
                            $translation = Translation::firstOrNew([
                                'locale' => $locale,
                                'group'  => $group,
                                'key'    => $key,
                            ]);

                            // Check if the database is different then the files
                            $newStatus = $translation->value === $value ? Translation::STATUS_SAVED : Translation::STATUS_CHANGED;
                            if ($newStatus !== (int)$translation->status) {
                                $translation->status = $newStatus;
                            }

                            // Only replace when empty, or explicitly told so
                            if ($replace || !$translation->value) {
                                $translation->value = $value;
                            }

                            $translation->save();

                            $counter++;
                        }
                    }
                }
            }

            return $counter;
        }
    }

    public function findTranslations($path = null)
    {
        if (is_callable($configVal = $this->getConfig('find_enabled')) ? $configVal() : $configVal) {
            $path      = $path ?: base_path();
            $keys      = [];
            $functions = ['trans', 'trans_choice', 'Lang::get', 'Lang::choice', 'Lang::trans', 'Lang::transChoice', '@lang', '@choice', '__'];
            $pattern   =                              // See http://regexr.com/392hu
                "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
                "(" . implode('|', $functions) . ")" .  // Must start with one of the functions
                "\(" .                               // Match opening parenthese
                "[\'\"]" .                           // Match " or '
                "(" .                                // Start a new group to match:
                "[a-zA-Z0-9_-]+" .               // Must start with group
                "([.][^\1)]+)+" .                // Be followed by one or more items/keys
                ")" .                                // Close group
                "[\'\"]" .                           // Closing quote
                "[\),]";                            // Close parentheses or new parameter

            // Find all PHP + Twig files in the app folder, except for storage
            $finder = new Finder();
            $finder->in($path)->exclude('storage')->name('*.php')->name('*.twig')->files();

            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            foreach ($finder as $file) {
                // Search the current file for the pattern
                if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                    // Get all matches
                    foreach ($matches[2] as $key) {
                        $keys[] = $key;
                    }
                }
            }
            // Remove duplicates
            $keys = array_unique($keys);

            // Add the translations to the database, if not existing.
            foreach ($keys as $key) {
                // Split the group and item
                [$group, $item] = explode('.', $key, 2);
                $this->missingKey('', $group, $item);
            }

            // Return the number of found translations
            return count($keys);
        }
    }

    public function exportTranslations($group)
    {
        if (!in_array($group, is_callable($configVal = $this->config['exclude_groups']) ? $configVal() : $configVal)) {
            if ($group === '*') {
                $this->exportAllTranslations();

                return;
            }

            if (!(is_callable($configVal = $this->getConfig('skip_export_to_file')) ? $configVal() : $configVal)) {
                $tree = $this->makeTree(Translation::ofTranslatedGroup($group)->orderByGroupKeys(Arr::get($this->config, 'sort_keys', false))->get());

                foreach ($tree as $locale => $groups) {
                    if (isset($groups[$group])) {
                        $translations = $groups[$group];
                        $path         = $this->app['path.lang'] . '/' . $locale . '/' . $group . '.php';
                        $output       = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
                        $this->files->put($path, $output);
                    }
                }
            }

            Translation::ofTranslatedGroup($group)->update(['status' => Translation::STATUS_SAVED]);

            $this->events->dispatch(new Events\Published($group));
        }
    }

    public function exportAllTranslations()
    {
        $groups = Translation::whereNotNull('value')->selectDistinctGroup()->get('group');

        foreach ($groups as $group) {
            $this->exportTranslations($group->group);
        }
    }

    public function cleanTranslations()
    {
        Translation::whereNull('value')->delete();
    }

    public function truncateTranslations()
    {
        Translation::truncate();
    }

    protected function makeTree($translations)
    {
        $array = [];

        foreach ($translations as $translation) {
            Arr::set($array[$translation->locale][$translation->group], $translation->key, $translation->value);
        }

        return $array;
    }

    public function getConfig($key = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return $this->config[$key];
    }

}
