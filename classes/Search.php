<?php

class Search {

  //public $termsToSearch;

  // public function __construct($termsToSearch) {

  //   $this->termsToSearch = $termsToSearch;
  //   return $this->termsSerched = $this->searchTerms($this->termsToSearch);

  // }

	public static function searchTerms($termsToSearch, $startRow = 0, $totalRows = 10) {

    $query = "SELECT livro_nome,
                      cap, 
                      ver, 
                      texto,
                      livro_slug,
                      MATCH (texto) 
                      AGAINST (:terms) 
                      AS SCORE 
                      FROM bibliakja AS biblia
                      LEFT JOIN biblia_livros AS bl
                      ON bl.cod_livro = biblia.cod_livro
                      WHERE MATCH (texto) 
                      AGAINST (:terms) > 0
                      LIMIT $startRow,$totalRows";

		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':terms', $termsToSearch);
		$statement->execute();
		return $statement->fetchAll();
  }
  
  public static function searchTermsByBooks($termsToSearch, $book, $startRow = 0, $totalRows = 10) { //$book = livro_slug

    $query = "SELECT livro_nome,
                      cap, 
                      ver, 
                      texto,
                      livro_slug,
                      MATCH (texto) AGAINST (:terms) 
                      AS SCORE 
                      FROM bibliakja AS biblia
                      LEFT JOIN biblia_livros AS bl
                      ON bl.cod_livro = biblia.cod_livro
                      WHERE MATCH (texto) 
                      AGAINST (:terms) > 0
                      AND livro_slug = $book
                      LIMIT $startRow,$totalRows";

		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':terms', $termsToSearch);
		$statement->execute();
		return $statement->fetchAll();
	}

  public static function totalRowsByBooks ($termsToSearch) {

    $query = "SELECT livro_nome, COUNT(*) AS TOTAL
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms) > 0
    GROUP BY bl.id";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->execute();
    return $statement->fetchAll();
  }

  public static function totalRows ($termsToSearch) {

    $query = "SELECT COUNT(cod_livro) AS TOTAL
    FROM bibliakja
    WHERE MATCH (texto) AGAINST (:terms) > 0";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->execute();
    return $statement->fetch();
  }
}
?>