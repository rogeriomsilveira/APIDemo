<?php

namespace Application\Controller;

use Helper\Response\Header;
use Helper\Request\Loader;
use Helper\Request\Validator;
use Application\Service\UserService;

/* ------------------------------------------------------------------------------------------------- */

class UserController
{
    private $userService;
    private $header;
    private $loader;
    private $validator;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(UserService $userService)
    {
        $this->loader = new Loader();

        $validKeys = array('name', 'username', 'email', 'password');
        $this->validator = new Validator($validKeys);

        $this->header = new Header();
        $this->userService = $userService;
    }

    /* ================================================================================================= */

    public function readUserById($id)
    {
        $user = $this->userService->readUserById($id);
        $this->header->response('success', 'get', $user);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readUserByUsername($username)
    {
        $user = $this->userService->readUserByUsername($username);
        $this->header->response('success','get', $user);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readAllUsers()
    {
        $userList = $this->userService->readAllUsers();
        $this->header->response('success', 'get', $userList);
    }    

    /* ------------------------------------------------------------------------------------------------- */

    public function createUser() {
        $payload = $this->loader->parseRequest();
        $this->validator->validatePostRequest($payload);
        $this->userService->createUser($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function updateUser($userId) {
        $payload = $this->loader->parseRequest();
        $this->validator->validatePutRequest($payload);
        $this->userService->updateUser($payload, $userId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteUser($userId) {
        $this->userService->deleteUser($userId);
    }

    /* ================================================================================================= */

}