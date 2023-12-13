SELECT
	latitude,
	longitude,
	date_time
FROM locations
WHERE user_id = :user_id 
ORDER BY
	date_time DESC,
	id DESC;