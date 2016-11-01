<?php

namespace App\AuthAdapters;

use App\Facilitator\App\JWTFacilitator;
use App\Facilitator\Database\DatabaseFacilitator;
use App\Mapper\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use SlimAuth\AuthAdapterInterface;
use SlimAuth\AuthResponse;

class AuthAdapterUserDoctrine implements AuthAdapterInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var DocumentManager
     */
    private $databaseConnection;

    /**
     * AuthAdapterUser constructor.
     *
     * @param $username string
     * @param $password string
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    function authenticate() : AuthResponse
    {

        $date = new \DateTime('now');
        $date->add(new \DateInterval('PT10H'));

        $this->databaseConnection = DatabaseFacilitator::getConnection();
        $arrayUser = $this->databaseConnection->getRepository(User::class)
            ->findBy(array('username' => $this->username, 'password' => $this->password));

        if (count($arrayUser) == 0) {
            return new AuthResponse(AuthResponse::AUTHRESPONSE_FAILURE, 'User not found');
        }

        $user = $arrayUser[0];

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'id' => $user->id,
            'exp' => $date->getTimestamp()
        ];

        $token = JWTFacilitator::createToken($header, $payload, $user->password);

        return new AuthResponse(AuthResponse::AUTHRESPONSE_SUCCESS, 'User auth success', 'token', [ 0 => $token ]);
    }

}