<?php

namespace Application\Controller;

use Helper\Response\Header;
use Helper\Request\Loader;
use Helper\Request\Validator;
use Application\Service\CartService;

/* ------------------------------------------------------------------------------------------------- */

class CartController
{
    private $cartService;
    private $header;
    private $loader;
    private $validator;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(CartService $cartService)
    {
        $this->loader = new Loader();

        $validKeys = array("customer_id", "product_id", "quantity");
        $this->validator = new Validator($validKeys);

        $this->header = new Header();
        $this->cartService = $cartService;
    }

    /* ================================================================================================= */

    public function readCart($customerId)
    {
        $cart = $this->cartService->readCart($customerId);
        $this->header->response('success', 'get', $cart);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readCartAbsentItems($customerId)
    {
        $customer = $this->cartService->readCartAbsentItems($customerId);
        $this->header->response('success','get', $customer);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createCartItem() {
        $payload = $this->loader->parseRequest();
        $this->validator->validatePostRequest($payload);
        $this->cartService->createCartItem($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartItem($productId, $customerId) {
        $this->cartService->deleteCartItem($productId, $customerId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteCartAllItems($customerId) {
        $this->cartService->deleteCartAllItems($customerId);
    }

    /* ================================================================================================= */

}