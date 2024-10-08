<?php

namespace Barryvdh\TranslationManager;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use JorisvanW\DeepL\Laravel\Facades\DeepL;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\TranslationManager\Models\Translation;

class ServiceController extends BaseController
{
    protected Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function postBulk(Request $request, $group = null)
    {
        $services = $this->manager->getConfig('services');

        if (!in_array($group, (is_callable($configVal = $this->manager->getConfig('exclude_groups')) ? $configVal() : $configVal))) {
            $keys         = explode('|', request()->get('keys'));
            $localeBase   = request()->get('locale_base');
            $localeTarget = request()->get('locale_target');

            if (Arr::get($services, 'deepl.enabled', false) && $localeBase !== $localeTarget) {
                $translations = Translation::query()->OfTranslatedGroup($group)->locale($localeBase)->whereIn('key', $keys)->where('value', '!=', '');

                $counter              = 0;
                $translationsResponse = [];
                foreach ($translations->cursor() as $translationBase) {
                    $value = DeepL::api()->translateText($translationBase->value, $localeTarget, $localeBase);

                    $translation = Translation::firstOrNew([
                        'locale' => $localeTarget,
                        'group'  => $group,
                        'key'    => $translationBase->key,
                    ]);

                    $translation->value  = (string)$value ?: null;
                    $translation->status = Translation::STATUS_CHANGED;
                    $translation->save();

                    $translationsResponse[$translation->key] = $translation->value;

                    $counter++;
                }

                return [
                    'status'        => 'ok',
                    'locale_base'   => $localeBase,
                    'locale_target' => $localeTarget,
                    'counter'       => $counter,
                    'translations'  => $translationsResponse,
                ];
            }
        }
    }

    public function postUsage(Request $request)
    {
        $services = $this->manager->getConfig('services');

        if (Arr::get($services, 'deepl.enabled', false)) {
            $usage = DeepL::api()->usage()->get();

            return [
                'status' => 'ok',
                'text'   => 'Usage: ' . $usage->character_count . '/' . $usage->character_limit,
            ];
        }
    }
}
