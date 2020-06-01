<?php

namespace Reached\WidgetAble;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

trait Widgetable {

    public function findWidget($model, $name)
    {
        $class = $model;
        $instance = new $class();

        if(App::environment('local')) {
            return $instance->firstOrCreate(
                ['block_name' => $name],
                ['text' => "Some text for the $name widget"]
            );
        }

        return Cache::remember($model . '-' . $name, now()->addHours(12), function() use($instance, $name) {
            return $instance->where('block_name', $name)->first();
        });
    }
}
