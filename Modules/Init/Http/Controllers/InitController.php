<?php

namespace Modules\Init\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Modules\Init\Helpers\BaseHelper;
use Modules\Init\Supports\Language;

class InitController extends Controller
{
    public function handleTranslation(Request $request, $lang = false)
    {
        $groups = Language::getAvailableLocales();
        $defaultLanguage = Arr::get($groups, 'en');

        if (!$lang) {
            $group = $defaultLanguage;
        } else {
            $group = Arr::first(Arr::where($groups, function ($item) use ($request, $lang) {
                return $item['locale'] == $lang;
            }));
        }


        $translations = [];
        if ($group) {
            $jsonFile = lang_path($group['locale'] . '.json');

            if (!File::exists($jsonFile)) {
                $jsonFile = base_path('resources/lang/' . $group['locale'] . '.json');
            }

            if (!File::exists($jsonFile)) {
                $languages = BaseHelper::scanFolder(theme_path(Theme::getThemeName() . '/lang'));

                if (!empty($languages)) {
                    $jsonFile = base_path('resources/lang/' . Arr::first($languages));
                }
            }

            if (File::exists($jsonFile)) {
                $translations = BaseHelper::getFileData($jsonFile);
            }


//            if ($group['locale'] != 'en') {
//                $defaultEnglishFile = lang_path('en.json');
//
//                if ($defaultEnglishFile) {
//                    $enTranslations = BaseHelper::getFileData($defaultEnglishFile);
//                    $translations = array_merge($enTranslations, $translations);
//
//                    $enTranslationKeys = array_keys($enTranslations);
//
//                    foreach ($translations as $key => $translation) {
//                        if (!in_array($key, $enTranslationKeys)) {
//                            Arr::forget($translations, $key);
//                        }
//                    }
//                }
//            }
        }
        ksort($translations);

        return Inertia::render('@Init::Translation/Index', [
            'translations' => $translations,
        ]);
    }

    public function saveTranslation(Request $request)
    {
        if (!File::isWritable(lang_path())) {
            return back()->with('alert', [
                'type' => 'error',
                'message' => 'Lang Directory is not writable',
            ]);
        }


        $locale = $request->input('lang');

        if ($locale) {
            $translations = [];
            $jsonFile = lang_path($locale . '.json');

            if (File::exists($jsonFile)) {
                $translations = BaseHelper::getFileData($jsonFile);
            }

            ksort($translations);
            $translations = array_combine(array_map('trim', array_keys($translations)), $translations);
            $postedTranslations = $request->input('data');
            foreach ($postedTranslations as $item) {
                $translations[$item['key']] = $item['value'];
            }

            File::put(lang_path($locale . '.json'), json_encode($translations, JSON_UNESCAPED_UNICODE |
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return back()->with('alert', [
                'type' => 'success',
                'message' => 'Translation Saved Successfully'
            ]);

        }


    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('init::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('init::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('init::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('init::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
