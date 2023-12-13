<?php

namespace Application\Service;

use Helper\Response\Header;
use Application\Repository\CartRepository;

/* ------------------------------------------------------------------------------------------------- */

class CartService
{
    private $cartRepository;
    private $header;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->header = new Header();
    }

    /* ================================================================================================= */

    public function readCart($customerId)
    {
        return $this->cartRepository->readCart($customerId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readCartAbsentItems($customerId)
    {
        return $this->cartRepository->readCartAbsentItems($customerId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createCartItem($payload) {
        $this->validateDataEntry($payload);
        $this->cartRepository->createCartItem($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartItem($productId, $customerId) {
        $this->cartRepository->deleteCartItem($productId, $customerId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartAllItems($customerId) {
        $this->cartRepository->deleteCartAllItems($customerId);
    }

    /* =================================================================================================

        Validations of business rules must be done here.
        Also, if the data must be modified in some way (changing case, encoding password, etc),
        that should be done here too.

       ================================================================================================= */

    private function validateDataEntry($payload) {
        foreach($payload as $key) {
            if (!is_numeric($key)) {
                $this->header->response('error', 'validation', array('code'=>4660, 'message'=>"Payload is invalid. All values must be numeric."));
            }
        }
    }

    /* ================================================================================================= */

}