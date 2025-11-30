<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    private static $key = "MYSECRETKEY12345";

    public static function generateToken($userId)
    {
        $payload = [
            'iss' => "phantasm",
            'iat' => time(),
            'exp' => time() + 60*60*24,
            'user_id' => $userId
        ];
        return JWT::encode($payload, self::$key, 'HS256');
    }

    public static function verifyToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
