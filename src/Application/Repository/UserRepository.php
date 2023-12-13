<?php

namespace Application\Repository;

use PDO;
use  Helper\Response\Header;
use Helper\Database\Statement;


/* ------------------------------------------------------------------------------------------------- */

class UserRepository  {

    private $db;
    private $header;
    private $statement;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->header = new Header();
        $this->statement = new Statement('user');
    }

    /* ================================================================================================= */

    public function readUserById($id) {
        try {
            $query = $this->statement->load('readUserById');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readUserByUsername($userName) {
        try {
            $query = $this->statement->load('readUserByUsername');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':username', $userName, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readAllUsers() {
        try {
            $query = $this->statement->load('readAllUsers');
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createUser($payload) {
        try {
            $query = $this->statement->load('createUser');
            $statement = $this->db->prepare($query);
            foreach($payload as $key => $value) {
                $statement->bindValue(":$key", $value, PDO::PARAM_STR);
            }
            $statement->execute();
            $this->header->response('success', 'post', array('table'=>'user', 'id'=> $this->db->lastInsertId()));
        } catch (\Throwable $e) {
            $this->header->response('error', 'post', $this->checkForDuplicateEntry($e->getMessage(), $payload['username']));
        }
    }    

    /* ------------------------------------------------------------------------------------------------- */

    public function updateUser($payload, $userId) {
        try {
            $query = $this->statement->load('updateUser');
            $query = str_replace("%columnsToUpdate%", $this->columnsToUpdate($payload), $query);
            $statement = $this->db->prepare($query);
            $statement->bindParam(":id", $userId, PDO::PARAM_INT);
            foreach($payload as $key => $value) {
                $statement->bindValue(":$key", $value, PDO::PARAM_STR);
            }
            $statement->execute();
            $this->checkForResourceNotFound('put', $statement, $userId);
            $this->header->response('success', 'put', array('table'=>'user', 'id'=> $this->db->lastInsertId()));
        } catch (\Throwable $e) {
            $this->header->response('error', 'put', $this->checkForDuplicateEntry($e->getMessage(), $payload['username']));
        }
    }    

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteUser($userId) {
        try {
            $query = $this->statement->load('deleteUser');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $userId, PDO::PARAM_INT);
            $statement->execute();
            $this->checkForResourceNotFound('delete', $statement, $userId);
            $this->header->response('success', 'delete', array('table'=>'user', 'id'=>$userId));
        } catch (\Throwable $e) {
            $this->header->response('error', 'delete', "Error: {$e->getMessage()}");
        }
    }

    /* ================================================================================================= */

    private function columnsToUpdate($payload) {
        $columns = "";
        foreach(array_keys($payload) as $key) {
            $columns .= "{$key} = :{$key}, ";
        }
        return trim($columns, ", ");
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function checkForDuplicateEntry($errorMessage, $userName) {
        $errorMessage = "Error: {$errorMessage}.";
        if (str_contains($errorMessage, '1062 Duplicate entry') && str_contains($errorMessage, 'users.username')) {
            $errorMessage = array('type'=>'duplicated', 'table'=>'user', 'key'=>'username', 'value'=>$userName);
        }
        return $errorMessage;
    }

    /* ------------------------------------------------------------------------------------------------- */

    private function checkForResourceNotFound($method, $statement, $userId) {
        if ($statement->rowCount() == 0) {
            $this->header->response('error', $method, array('type'=>'notfound', 'table'=>'user', 'key'=>'id', 'value'=>$userId));
        }
    }

    /* ================================================================================================= */

}