SELECT
	ct.id as category_id,
	ct.name as category,
	p.id as product_id,
	p.name as product_name,
	p.price as unit_price
FROM
	products p
LEFT JOIN categories ct ON p.category_id = ct.id
LEFT OUTER JOIN carts c ON p.id = c.product_id AND c.customer_id = :customer_id
WHERE c.product_id IS NULL
ORDER BY ct.name, p.name