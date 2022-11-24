php -S localhost:8000 -t public

SELECT * FROM medias WHERE MATCH ('name', 'description') AGAINST("sit")