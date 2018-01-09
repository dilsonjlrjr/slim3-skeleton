<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 09/01/2018
 * Time: 08:57
 */

namespace App\Modules\API;


class Module
{

    public function getControllers() {
        return [
            realpath(__DIR__ . '/Http/Controller'),
//            realpath(__DIR__ . '/Http/Controller'),
        ];
    }

}