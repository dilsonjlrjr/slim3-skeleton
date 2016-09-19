<?php

namespace App\Facilitator\App;


use Namshi\JOSE\JWS;
use Namshi\JOSE\SimpleJWS;

class JWTFacilitator
{

    /**
     * Create token with format JWT
     *
     * @param array $header
     * @param array $payload
     * @param string $secret
     * @return string
     */
    public static function createToken(array $header, array $payload, string $secret) {

        $jwt = new SimpleJWS($header);
        $jwt->setPayload($payload);
        $jwt->sign($secret);

        return $jwt->getTokenString();
    }

    /**
     * @param string $token
     * @param string $secret
     * @return bool
     */
    public static function validateToken(string $token, string $secret) {

        $jws = JWS::load($token);
        return $jws->verify($secret);

    }

    public static function tokenIsExpired(string $token, string $secret) {

        $jws = JWS::load($token);
        $jws->verify($secret);

        $jwt = new SimpleJWS($jws->getHeader());
        $jwt->setPayload($jws->getPayload());

        return $jwt->isExpired();

    }

}