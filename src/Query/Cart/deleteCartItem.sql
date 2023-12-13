DELETE FROM carts 
WHERE customer_id = :customer_id 
AND product_id = :product_id;