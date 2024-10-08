<?php

namespace Barryvdh\TranslationManager;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    protected Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function getIndex($group = null)
    {
        $locales        = $this->loadLocales();
        $groups         = Translation::groupBy('group');
        $excludedGroups = (is_callable($configVal = $this->manager->getConfig('exclude_groups')) ? $configVal() : $configVal);
        if ($excludedGroups) {
            $groups->whereNotIn('group', $excludedGroups);
        }

        $groups = $groups->select('group')->get()->pluck('group', 'group');
        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }
        $groups     = ['' => 'Choose a group'] + $groups;
        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();


        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations    = [];
        foreach ($allTranslations as $translation) {
            $translations[$translation->key][$translation->locale] = $translation;
        }

        return view('translation-manager::index')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numChanged', $numChanged)
            ->with('numTranslations', $numTranslations)
            ->with('config', $this->manager->getConfig())
            ->with('editUrl', $group === null ? '' : action('\Barryvdh\TranslationManager\Controller@postEdit', [$group]))
            ->with('deleteEnabled', (is_callable($configVal = $this->manager->getConfig('delete_enabled')) ? $configVal() : $configVal));
    }

    public function getView($group = null)
    {
        return $this->getIndex($group);
    }

    protected function loadLocales()
    {
        //Set the default locale as the first one.
        $locales = Translation::groupBy('locale')
                              ->select('locale')
                              ->get()
                              ->pluck('locale');

        if ($locales instanceof Collection) {
            $locales = $locales->all();
        }
        $locales = array_merge([config('app.locale')], $locales);
        return array_unique($locales);
    }

    public function postAdd($group = null)
    {
        $keys = explode("\n", request()->get('keys'));

        foreach ($keys as $key) {
            $key = trim($key);
            if ($group && $key) {
                $this->manager->missingKey('*', $group, $key);
            }
        }
        return redirect()->back();
    }

    public function postEdit($group = null)
    {
        if (!in_array($group, (is_callable($configVal = $this->manager->getConfig('exclude_groups')) ? $configVal() : $configVal))) {
            $name  = request()->get('name');
            $value = request()->get('value');

            [$locale, $key] = explode('|', $name, 2);
            $translation         = Translation::firstOrNew([
                'locale' => $locale,
                'group'  => $group,
                'key'    => $key,
            ]);
            $translation->value  = (string)$value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();
            return ['status' => 'ok'];
        }
    }

    public function postDelete($group, $key)
    {
        if (!in_array($group, (is_callable($configVal = $this->manager->getConfig('exclude_groups')) ? $configVal() : $configVal)) && (is_callable($configVal = $this->manager->getConfig('delete_enabled')) ? $configVal() : $configVal)) {
            Translation::where('group', $group)->where('key', $key)->delete();
            return ['status' => 'ok'];
        }
    }

    public function postImport(Request $request)
    {
        if (is_callable($configVal = $this->manager->getConfig('import_enabled')) ? $configVal() : $configVal) {
            $replace = $request->get('replace', false);
            $counter = $this->manager->importTranslations($replace);

            return ['status' => 'ok', 'counter' => $counter];
        }
    }

    public function postFind()
    {
        $numFound = $this->manager->findTranslations();

        return ['status' => 'ok', 'counter' => (int)$numFound];
    }

    public function postPublish($group = null)
    {
        $this->manager->exportTranslations($group);

        return ['status' => 'ok'];
    }
}
