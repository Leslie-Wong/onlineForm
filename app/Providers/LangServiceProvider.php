<?php

namespace App\Providers;


use Inertia\Inertia;
use App\Models\Language;
use App\Helpers\TranslationsHelper;
use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->registerInertia();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerInertia()
    {
        // Inertia::version(fn () => md5_file(public_path('mix-manifest.json')));

        Inertia::share([
            'locale' => function () {
                return Language::where('code', app()->getLocale())->first();
            },
            'languages' => function () {
                $langs = json_encode(glob(resource_path('lang/*.json')));
                $p = str_replace('"',"",json_encode(resource_path('lang/')));
                $langs = str_replace($p,"",$langs);
                $langs = str_replace(".json","",$langs);

                $allLang = Language::whereIn('code', json_decode($langs))->get();
                return json_decode($allLang);

                // return json_decode($langs);
            },
            'language' => function () {
                return TranslationsHelper::translations(
                    resource_path('lang/'. app()->getLocale() .'.json')
                );
            },
        ]);
    }
}
