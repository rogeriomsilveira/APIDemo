<?php

namespace Helper\Core;

/* ------------------------------------------------------------------------------------------------- */

class Environment {

    static $values = array();

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct() {

        try {
            if (empty(self::$values)) {
                $root = dirname(__DIR__, 2);
                $fileName = "{$root}/.env";
                $lines = file($fileName);
                foreach($lines as $line) {
                    $line = trim($line);
                    if (!empty($line)) {
                        $parts = explode("=", $line);
                        self::$values[trim($parts[0], " =")] = trim($parts[1]);
                    }
                }
            }
        } catch (\Throwable $e) {
            throw new \Exception("Error: {$e->getCode()} {$e->getMessage()}.");
        }
    }

    /* ================================================================================================= */

    public function get($key) {
        try {
            if (array_key_exists($key, self::$values)) {
                return self::$values[$key];
            }
            throw new \Exception("Enviroment key ".$key." not found.");
        } catch (\Throwable $e) {
            throw new \Exception("Error: {$e->getCode()} {$e->getMessage()}.");
        }
    }

    /* ================================================================================================= */

}


