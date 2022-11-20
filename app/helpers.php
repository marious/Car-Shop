<?php
function my_lang($json, $locale = 'en') {
    if (!$locale) {
        $locale = app()->getLocale();
    }
    $data = json_decode($json, true);
    return $data[$locale] ? $data[$locale] : $json;
}
