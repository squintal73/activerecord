<?php

namespace app\classes;

class Uri
{
    // Returns the URI path of the current request
    public static function uri()
    {
        // Uses the parse_url function to extract the path from the REQUEST_URI value stored in $_SERVER
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}
