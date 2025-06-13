<?php

class SecurityHelper {

    private static string $apiKey = "Bearer IDjiaosudh128eudaj8ih";
    public static function isAPIKeyValid(): bool {
        
        $auth = getallheaders();
        if ($auth['Authorization'] == self::$apiKey) { 
               return true;
            }
               return false;
    }

    public static function generateAPIAccessError() {
        (new Response(httpCode: 401))->generateResponse();
    }
}

?>