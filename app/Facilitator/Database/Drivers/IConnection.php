<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 15/01/17
 * Time: 10:17
 */

namespace App\Facilitator\Database\Drivers;


interface IConnection
{
    function fabConnection();
    function createConnection();
    function getConnection();
}