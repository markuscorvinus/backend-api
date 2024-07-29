<?php

namespace Database\Factories\Helpers;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class FactoryHelpers
{
    public static function getRandomModelId($model)
    {
        $count = $model::query()->count();
        if ($count == 0) {
            $model::factory()->create();
            $count = $model::query()->count();
        }
        return rand(1, $count);
    }
}
