<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 15/01/17
 * Time: 10:44
 */

namespace App\Facilitator\Database\Drivers\Eloquent;


class Eloquent extends Allquent
{
    public function __construct($name)
    {
        parent::__construct($name);
    }
}