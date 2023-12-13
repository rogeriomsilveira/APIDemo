<?php

namespace Application\Repository;

use PDO;
use Helper\Response\Header;
use Helper\Database\Statement;


/* ------------------------------------------------------------------------------------------------- */

class CartRepository  {

    private $db;
    private $header;
    private $statement;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->header = new Header();
        $this->statement = new Statement('cart');
    }

    /* ================================================================================================= */

    public function readCart($customerId) {
        try {
            $query = $this->statement->load('readCart');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readCartAbsentItems($customerId) {
        try {
            $query = $this->statement->load('readCartAbsentItems');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createCartItem($payload) {
        try {
            $query = $this->statement->load('createCartItem');
            $statement = $this->db->prepare($query);
            foreach($payload as $key => $value) {
                $statement->bindValue(":$key", $value, PDO::PARAM_INT);
            }
            $statement->execute();
            $this->header->response('success', 'post', array('table'=>'carts', 'id'=> $this->db->lastInsertId()));
        } catch (\Throwable $e) {
            $this->header->response('error', 'generic', "Error: {$e->getMessage()}");
        }
    }    

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartItem($productId, $customerId) {
        try {
            $query = $this->statement->load('deleteCartItem');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $statement->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount() == 0) {
                $this->header->response('error', 'delete', array('type'=>'notfound', 'table'=>'carts', 'keys'=>array('customer_id'=>$customerId, 'product_id'=>$productId)));
            }
            $this->header->response('success', 'delete', array('table'=>'carts', 'keys'=>array('customer_id'=>$customerId, 'product_id'=>$productId)));
        } catch (\Throwable $e) {
            $this->header->response('error', 'delete', "Error: {$e->getMessage()}");
        }
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartAllItems($customerId) {
        try {
            $query = $this->statement->load('deleteCartAllItems');
            $statement = $this->db->prepare($query);
            $statement->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount() == 0) {
                $this->header->response('error', 'delete', array('type'=>'notfound', 'table'=>'carts', 'keys'=>array('customer_id'=>$customerId)));
            }
            $this->header->response('success', 'delete', array('table'=>'carts', 'keys'=>array('customer_id'=>$customerId)));
        } catch (\Throwable $e) {
            $this->header->response('error', 'delete', "Error: {$e->getMessage()}");
        }
    }

    /* ================================================================================================= */

}