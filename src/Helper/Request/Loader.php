<?php

namespace Helper\Request;

use  Helper\Response\Header;

/* ------------------------------------------------------------------------------------------------- */

class Loader {

    private $header;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct()
    {
        $this->header = new Header();
    }

    /* ================================================================================================= */

    public function parseRequest() {
        try {
            $payload = json_decode(file_get_contents('php://input'), true);
            $this->checkForEmptyPayload($payload);
        } catch (\Throwable $e) {
            $this->header->response('error', 'validation', "Error: {$e->getMessage()}.");
        }
        return $payload;
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function checkForEmptyPayload($payload) {
        if (empty($payload)) {
            $this->header->response('error', 'validation', array('code'=>1610, 'message'=>"Payload is empty."));
        }        
    }

    /* ================================================================================================= */

}