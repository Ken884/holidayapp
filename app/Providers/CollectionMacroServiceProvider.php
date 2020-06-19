<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class CollectionMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        Collection::macro('transpose', function () {
            $this->transform(function($v, $k){
                if($v instanceof Collection) return $v->all();
                return $v;
            });
            $transposed_array = array_map(null, ...$this->values());
            return collect($transposed_array)->map(function($v, $k){
                return array_combine($this->keys()->all(), $v);
            });
        });

        // 多次元配列を再帰的にCollectionに変換する。
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
