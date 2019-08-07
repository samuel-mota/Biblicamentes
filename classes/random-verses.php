<?php
//require_once 'load-classes.php'; nao funciona aqui :(
require_once 'db-config.php';
require_once 'Connect.php';

$queryRandomVerses = "TRUNCATE biblia_random_verses;

INSERT INTO biblia_random_verses (cap, ver, texto, livro_nome, cod_biblia, cod_livro)
SELECT bk.cap, bk.ver, bk.texto, bl.livro_nome, bk.cod, bl.cod_livro 
FROM bibliakja AS bk
LEFT JOIN biblia_livros AS bl 
ON bk.cod_livro = bl.cod_livro
JOIN (SELECT CEIL(RAND() * (SELECT MAX(id) FROM bibliakja)) AS id) AS random
WHERE bk.id = random.id;

INSERT INTO biblia_random_verses (cap, ver, texto, livro_nome, cod_biblia, cod_livro)
SELECT bk.cap, bk.ver, bk.texto, bl.livro_nome, bk.cod, bl.cod_livro 
FROM bibliakja AS bk
LEFT JOIN biblia_livros AS bl 
ON bk.cod_livro = bl.cod_livro
JOIN (SELECT CEIL(RAND() * (SELECT MAX(id) FROM bibliakja)) AS id) AS random
WHERE bk.id = random.id";

$connection = Connect::getConnection();
$statement = $connection->prepare($queryRandomVerses);

$statement->execute(); 
//$statement->fetchAll(); não precisa

?>