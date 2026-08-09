<?php

use Illuminate\Support\Facades\Lang;

if (!function_exists('model_trans')) {
    /**
     * Translate a key for a given model.
     *
     * Resolution order:
     *   1. "{$model}.{$key}"  → per-model override (e.g. terminal.pages.index)
     *   2. "placeholders.{$key}"    → shared pattern with :model / :models injected
     *
     * @param  string  $model  Lang file name of the model (e.g. 'terminal')
     * @param  string  $key    Dot key (e.g. 'pages.index', 'labels.new_record')
     */
    function model_trans(string $model, string $key, array $replace = []): string
    {
        $replace = array_merge([
            'model'  => __("$model.singular"),
            'models' => __("$model.plural"),
        ], $replace);

        return Lang::has("$model.$key")
            ? __("$model.$key", $replace)
            : __("placeholders.$key", $replace);
    }
}
