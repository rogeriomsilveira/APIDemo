<?php

namespace Helper\Response;

/* ------------------------------------------------------------------------------------------------- */

class Header {
    
    private $status = 200;
    private $message = "OK";
    private $data;

    /* ================================================================================================= */

    public function __set($atrib, $value) {
        $this->$atrib = $value;
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function __get($atrib) {
        return $this->$atrib;
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function response($responseType, $requestType, $resource) {
        switch ($responseType) {
            case 'success':
                $this->responseSuccess($requestType, $resource);
                break;
            case 'error':
                $this->responseError($requestType, $resource);
                break;
        }
        header("HTTP/1.1 {$this->status} {$this->message}");
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($this->data);
        die();
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function responseSuccess($requestType, $resource) {
        switch ($requestType) {
            case 'get':
                if ($resource) {
                    $this->data = array(
                        'status'=>$this->status,
                        'code'=>1000,
                        'message'=>$this->message,
                        'data'=>$resource
                    );
                } else {
                    $this->data = array(
                        'status'=>'error',
                        'code'=>1004,
                        'message'=>'Resource not found.',
                        'data'=> (is_array($resource) ? array() : json_decode("{}"))
                    );            
                }
                break;
            case 'post':
                $this->status = 201;
                $this->message = 'Created';
                $this->data = array (
                    'status'=>'success',
                    'code'=>1010,
                    'message'=>'Resource created.',
                    'data'=>$resource
                );  
                break;
            case 'put':
                $this->status = 200;
                $this->message = 'Updated';
                $this->data = array (
                    'status'=>'success',
                    'code'=>1020,
                    'message'=>'Resource updated.'
                );  
                break;
            case 'delete':
                $this->status = 200;
                $this->message = 'Deleted';
                $this->data = array (
                    'status'=>'success',
                    'code'=>1030,
                    'message'=>'Resource deleted.',
                    'data'=>$resource
                );  
                break;
            case 'error':
                $this->data = array (
                    'status'=>'error',
                    'message'=>$resource
                );  
                break;
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function responseError($requestType, $resource) {
        switch ($requestType) {
            case 'post':
                $this->status = 200;
                $this->message = 'Not created';
                if (is_array($resource)) {
                    $this->data = array (
                        'status'=>'error',
                        'code'=>1015,
                        'message'=>'Not created. Resource already exists.',
                        'data'=>array('table'=>$resource['table'], 'keys'=>$resource['keys'])
                    );  
                } else {
                    $this->data = $resource;
                }
                break;
            case 'put':
                $this->status = 200;
                $this->message = 'Not updated';
                if (is_array($resource)) {
                    switch ($resource['type']) {
                        case 'notfound':
                            $this->data = array (
                                'status'=>'error',
                                'code'=>1024,
                                'message'=>'Not updated. Resource not found or data not changed.',
                                'data'=>array('table'=>$resource['table'], 'keys'=>$resource['keys'])
                            );  
                        break;
                        case 'duplicated':
                            $this->data = array (
                                'status'=>'error',
                                'code'=>1025,
                                'message'=>'Not updated. Resource already exists.',
                                'data'=>array('table'=>$resource['table'], 'keys'=>$resource['keys'])
                            );  
                        break;
                    }
                } else {
                    $this->data = $resource;
                }
                break;
            case 'delete':
                $this->status = 200;
                $this->message = 'Not deleted';
                if (is_array($resource)) {
                    $this->data = array (
                        'status'=>'error',
                        'code'=>1034,
                        'message'=>'Not deleted. Resource not found.',
                        'data'=>array('table'=>$resource['table'], 'keys'=>$resource['keys'])
                    );  
                } else {
                    $this->data = $resource;
                }
                break;
            case 'validation':
                $this->status = 200;
                $this->message = 'Not deleted';
                if (is_array($resource)) {
                    $this->data = array (
                        'status'=>'error',
                        'code'=>$resource['code'],
                        'message'=>$resource['message']
                    );  
                } else {
                    $this->data = $resource;
                }
                break;
            default:
                $this->data = array (
                    'status'=>'error',
                    'code'=>-1,
                    'message'=>$resource
                );  
                break;
        }
    }

    /* ================================================================================================= */

}