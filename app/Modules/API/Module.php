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
    const NAME = 'API';

    public static function getPathModule() {
        return __DIR__ . '/../' . self::NAME;
    }

    public static function getControllers() {
        return realpath(__DIR__ . '/Http/Controller');
    }

    public static function getNameSpace() {
        return __NAMESPACE__;
    }

}