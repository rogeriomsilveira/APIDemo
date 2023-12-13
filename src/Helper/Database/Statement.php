<?php

namespace Helper\Database;

class Statement {

    private $segment;

    public function __construct($segment)
    {
        $this->segment = $segment;
    }

    /* ================================================================================================= */

    public function load($name) {
        try {
            $root = dirname(__DIR__, 2);
            $fileName = "{$root}/Query/{$this->segment}/{$name}.sql";
            $contents = file_get_contents($fileName);
            //Strip off double spaces, tabs and line feeds of the string
            $query = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $contents);
        } catch (\Throwable $e) {
            throw new \Exception("Error: {$e->getCode()} {$e->getMessage()}.");
        }
        return $query;
    }

    /* ================================================================================================= */

}


