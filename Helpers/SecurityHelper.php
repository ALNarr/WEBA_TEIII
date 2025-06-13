<?php

class SecurityHelper {

    private static string $apiKey = "IDjiaosudh128eudaj8ih";
    
    public static function isAPIKeyValid(): bool {
    if (!isset($_GET['apiKey'])) {
        return false;
    }
    elseif ($_GET['apiKey'] == self::$apiKey) {
        return true;
    }
    else{
        return false;
    }
}

    public static function generateAPIAccessError() {
        (new Response(httpCode: 401))->generateResponse();
    }
}

?>