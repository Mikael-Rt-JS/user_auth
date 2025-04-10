SELECT 
    pe.id AS expiration_id,
    pe.product_id,
    pe.expiration_date,
    pe.date_added,
    pe.added_by_user,
    p.name AS product_name,
    p.barcode,
    p.image
FROM 
    product_expirations pe
JOIN 
    products p ON pe.product_id = p.id
WHERE 
    pe.company_id = :company_id
ORDER BY 
    pe.date_added DESC
LIMIT :limit OFFSET :offset


----

SELECT 
    pe.id AS expiration_id,
    pe.product_id,
    pe.expiration_date,
    pe.date_added,
    p.name AS product_name,
    p.barcode,
    p.image
FROM 
    product_expirations pe
JOIN 
    products p ON pe.product_id = p.id
WHERE 
    pe.added_by_user = :user_id
ORDER BY 
    pe.date_added DESC

