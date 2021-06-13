<?php

class token_verifier
{
    const TOKEN_TTL = 10;
    const PASSWORD = "{{ password }}";

    static function decrypt($ivHashCiphertext)
    {
        $method = "AES-256-CBC";
        $iv = substr($ivHashCiphertext, 0, 16);
        $hash = substr($ivHashCiphertext, 16, 32);
        $ciphertext = substr($ivHashCiphertext, 48);
        $key = hash('sha256', token_verifier::PASSWORD, true);

        if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;

        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    }

    static function getCredentialsFromToken($encryptedToken)
    {
        $plaintextToken = token_verifier::decrypt((base64_decode(str_replace(' ', '+', urldecode($encryptedToken)))));
        $parts = explode("-", $plaintextToken);
        if (count($parts) != 3) {
            return false;
        }

        $now = time();
        $time_diff = $now - (int)$parts[2];
        /*print_object($time_diff);*/
        if ($time_diff > self::TOKEN_TTL) {
            return false;
        }
        return $parts;
    }
}