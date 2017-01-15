<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 25/10/16
 * Time: 08:54
 */

namespace App\Facilitator\App;


use RKA\Session;

class SessionFacilitator
{

    public static function getSession() {
        return new Session();
    }

    public static function getAttributeSession() {
        $session = new Session();
        return $session->get(self::getSessionName());
    }

    public static function destroy() {
        $session = new Session();
        $session->clearAll();
    }

    public static function getSessionName() {
        $ci = ContainerFacilitator::getContainer();
        $arraySettings = $ci->get('settings');

        return $arraySettings['session']['name'];
    }

}