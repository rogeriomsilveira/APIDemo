UPDATE users 
SET %columnsToUpdate%
WHERE id = :id
LIMIT 1