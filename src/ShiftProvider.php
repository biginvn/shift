<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 4/1/20
 * Time: 10:22 AM
 */

namespace Bigin\Shift;


use Illuminate\Support\ServiceProvider;

class ShiftProvider extends ServiceProvider
{

    public function boot(){
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'shift');
    }

    public function register(){}
}