<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHandler
{
    private static $secretKey = "your_secret_key"; 

    /**
     * Generate a token for authentication.
     * @param array $userRecord
     * @return string
     */
    public static function generateToken($userRecord)
    {
        $payload = [
            'user_data' => $userRecord,
            'iat' => time(), 
            'exp' => time() + (60 * 60) 
        ];

        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    /**
     * Verify the token and return the decoded data.
     * @param string $token
     * @return mixed
     */
    public static function verifyToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * Authorize user based on token.
     * @param string $token
     * @return bool
     */
    public static function authorizeUser($token)
    {
        if (!$token) {
            // No token provided
            echo "Unauthorized access, no token.";
            return false;
        }

        // Verify and decode the token
        $decoded = self::verifyToken($token);

        if ($decoded) {
            return true;
        } else {
            echo "User is not authorized.";
            return false;
        }
    }
}
// Generating a token
$userData = ['id' => 1, 'name' => 'Salam Hammad', 'role' => 'patient'];
$token = TokenHandler::generateToken($userData);
echo "Generated Token: " . $token . "\n";

// Verifying the token
$decodedData = TokenHandler::verifyToken($token);
if ($decodedData) {
    echo "Token is valid. Decoded Data: ";
    print_r($decodedData);
} else {
    echo "Invalid Token.";
}

// Authorizing a user
if (TokenHandler::authorizeUser($token)) {
    echo "Access granted.";
} else {
    echo "Access denied.";
}

?>
