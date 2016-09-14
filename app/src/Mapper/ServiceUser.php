<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 13/09/16
 * Time: 08:21
 */

namespace App\Mapper;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(db="BD_AUTH", collection="ServiceUser", repositoryClass="App\Mapper\Repository\ServiceUserRepository")
 */
class ServiceUser
{
    /**
     * @ODM\Id(strategy="AUTO")
     */
    public $id;

    /**
     * @ODM\Field(type="string")
     */
    public $username;

    /**
     * @ODM\Field(type="string")
     */
    public $password;
}