<?php

require_once ('token_verifier.php');

class webservice_base
{
    public static function getValidCredentials($t) {
        $userCredentials = token_verifier::getCredentialsFromToken($t);
        if (!$userCredentials) {
            return null;
        }

        if (webservice_base::check_enrollment($userCredentials[0], $userCredentials[1]) == false){
            return null;
        }
        $obj = new StdClass();
        $obj->userId = $userCredentials[0];
        $obj->courseId = $userCredentials[1];
        return $obj;
    }

    protected static function check_enrollment($userId, $courseId)
    {
        return is_enrolled(context_course::instance($courseId), $userId, '', true);
    }
}