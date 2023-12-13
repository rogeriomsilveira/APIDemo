SELECT
	c.id as id,
	t.id as category_id,
	t.name as category_name,
	p.id as product_id,
	p.name as product_name,
	p.price as unit_price,
	c.quantity as quantity,
	(p.price * c.quantity) as subtotal
FROM carts c
LEFT JOIN products p ON c.product_id = p.id
LEFT JOIN categories t ON p.category_id = t.id 
WHERE c.customer_id = :customer_id
ORDER BY t.name, p.name;