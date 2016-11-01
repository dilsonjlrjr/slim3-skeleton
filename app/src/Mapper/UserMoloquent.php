<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 31/10/16
 * Time: 14:50
 */

namespace App\Mapper;

use Moloquent\Eloquent\Model as Moloquent;

class UserMoloquent extends Moloquent
{
    protected $collection = 'User';

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


}