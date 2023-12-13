<?php

namespace Application\Repository;

use PDO;
use Helper\Response\Header;
use Helper\Database\Statement;

/* ------------------------------------------------------------------------------------------------- */

class LocationRepository  {

    private $db;
    private $header;
    private $statement;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->header = new Header();
        $this->statement = new Statement('location');
    }

    /* ================================================================================================= */

    public function readAllLocations($userId) {
        try {
            $query = $this->statement->load('readAllLocations');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readLastLocation($userId) {
        try {
            $query = $this->statement->load('readLastLocation');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createLocation($payload) {
        try {
            $query = $this->statement->load('createLocation');
            $statement = $this->db->prepare($query);
            foreach($payload as $key => $value) {
                $statement->bindValue(":$key", $value, PDO::PARAM_STR);
            }
            $statement->execute();
            $this->header->response('success', 'post', array('table'=>'location', 'id'=> $this->db->lastInsertId()));
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }    

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteAllLocations($userId) {
        try {
            $query = $this->statement->load('deleteAllLocations');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount() == 0) {              
                $this->header->response('error', 'delete', array('type'=>'notfound', 'table'=>'location', 'keys'=>array('user_id'=>$userId)));
            }
            $this->header->response('success', 'delete', array('table'=>'user', 'id'=>$userId));
        } catch (\Throwable $e) {
            $this->header->response('error', 'delete', "Error: {$e->getMessage()}");
        }
    }

    /* ================================================================================================= */

}