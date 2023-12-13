<?php

namespace Application\Service;

use  Helper\Response\Header;
use Application\Repository\UserRepository;

/* ------------------------------------------------------------------------------------------------- */

class UserService
{
    private $userRepository;
    private $header;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->header = new Header();
    }

    /* ================================================================================================= */

    public function readUserById($id)
    {
        return $this->userRepository->readUserById($id);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readUserByUsername($username)
    {
        return $this->userRepository->readUserByUsername($username);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readAllUsers()
    {
        return $this->userRepository->readAllUsers();
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createUser($payload) {
        $this->validateDataEntry($payload);
        $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        $this->userRepository->createUser($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function updateUser($payload, $id) {
        $this->validateDataEntry($payload);
        $this->userRepository->updateUser($payload, $id);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteUser($id) {
        $this->userRepository->deleteUser($id);
    }

    /* =================================================================================================

        Validations of business rules must be done here.
        Also, if the data must be modified in some way (changing case, encoding password, etc),
        that should be done here too.

       ================================================================================================= */
       
    private function validateDataEntry($payload) {

        $validKeys = array('name', 'username', 'email', 'password');

        foreach($validKeys as $key) {
            if (array_key_exists($key, $payload)) {
                if (empty($payload[$key])) {
                    $this->header->response('error', 'validation', array('code'=>1650, 'message'=>"Key {$key} cannot be empty."));
                }
                if ($key == 'name' && (strlen($payload['name']) < 4 || strlen($payload['name']) > 64)) {
                    $this->header->response('error', 'validation', array('code'=>1660, 'message'=>"Name is invalid. It must be between 4 and 64 characters long."));
                    $value = strtolower($value);
                }
                if ($key == 'username') {
                    if (!preg_match('/^[a-z]{1}[a-z0-9\d_]{3,15}$/i', $payload['username'])) {
                        $this->header->response('error', 'validation', array('code'=>1670, 'message'=>"Username is invalid. It must start with a letter, must be between 4 and 16 characters long and must have letters and numbers only."));
                    }
                    $payload['username'] = strtolower($payload['username']);
                } 
                if ($key == 'email') {
                    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
                        $this->header->response('error', 'validation', array('code'=>1680, 'message'=>"Invalid email address."));
                    }
                    $payload['email'] = strtolower($payload['email']);
                }
                if ($key == 'password') {
                    if (strlen($payload['password']) < 8) {
                        $this->header->response('error', 'validation', array('code'=>1690, 'message'=>"Password must be at least 8 characters long."));
                    }
                    $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
                }
            }
        }
    }

/* ------------------------------------------------------------------------------------------------- */

}