<?php

namespace Core;

class Flash
{
    public static function set(string $name, $message)
    {
        if (!session_id()) session_start();

        $_SESSION[$name] = $message;
    }

    public static function get(string $name)
    {
        if (!session_id()) session_start();

        $result = isset($_SESSION[$name]) ? $_SESSION[$name] : [];
        
        unset($_SESSION[$name]);

        return $result;
    }

    public static function has(string $name)
    {
        if (!session_id()) session_start();

        if (!isset($_SESSION[$name])) return false;

        return true;
    }
}
