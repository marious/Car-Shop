<?php

use Modules\Init\Facades\FilterFacade as Filter;

if (!function_exists('add_filter')) {

    function add_filter($hook, $callback, int $priority = 20, int $arguments = 1) {
        Filter::addListener($hook, $callback, $priority, $arguments);
    }
}

if (!function_exists('remove_filter')) {
    function remove_fitler(string $hook) {
        Filter::removeListener($hook);
    }
}

if (!function_exists('apply_filters')) {
    function apply_filters() {
        $args = func_get_args();
        return Filter::fire(array_shift($args), $args);
    }

}