<?php

namespace Helper\Request;

use  Helper\Response\Header;

/* ------------------------------------------------------------------------------------------------- */

class Validator {

    private $header;
    private $validKeys;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct($validKeys=array())
    {
        $this->header = new Header();
        $this->validKeys = $validKeys;
    }

    /* ================================================================================================= */

    public function validatePostRequest($payload) {
        $this->checkForUnknownKeys($payload);
        $this->checkForKnownKeys($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function validatePutRequest($payload) {
        $this->checkForUnknownKeys($payload);
        $this->checkForAtLeastOneKey($payload);
    }

    /* ================================================================================================= */

    private function checkForUnknownKeys($payload) {
        foreach(array_keys($payload) as $key) {
            if (!in_array($key, $this->validKeys)) {
                $this->header->response('error', 'validation', array('code'=>1620, 'message'=>"Unknown key '".$key."' is in payload. Valid options are: '".implode("', '", $this->validKeys)."'."));
            }
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function checkForKnownKeys($payload) {
        foreach($this->validKeys as $key) {
            if (!array_key_exists($key, $payload)) {
                $this->header->response('error', 'validation', array('code'=>1630, 'message'=>"Key '{$key}' does not exists in payload."));
            }
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function checkForAtLeastOneKey($payload) {
        $keyCounter = 0;
        foreach($this->validKeys as $key) {
            if (array_key_exists($key, $payload)) {
                $keyCounter++;
            }
        }
        if ($keyCounter < 1) {
            $this->header->response('error', 'validation', array('code'=>1640, 'message'=>"There are no known keys in payload."));
        }        
    }

    /* ================================================================================================= */

}