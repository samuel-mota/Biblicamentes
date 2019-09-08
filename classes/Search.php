<?php

class Search {

  //public $termsToSearch;

  // public function __construct($termsToSearch) {

  //   $this->termsToSearch = $termsToSearch;
  //   return $this->termsSerched = $this->searchTerms($this->termsToSearch);

  // }

	public static function searchTerms($termsToSearch, $page = 1, $rowsPerPage) {
    if($page > 1):
      $startRow = ($page - 1) * $rowsPerPage;
    else:
      $startRow = 0;
    endif;

    $query = "SELECT livro_nome,
                      cap, 
                      ver, 
                      texto,
                      livro_slug,
                      MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) 
                      AS SCORE 
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    LIMIT $startRow,$rowsPerPage";

		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':terms', $termsToSearch);
		$statement->execute();
    return $statement->fetchAll();
  }
  
  
  public static function searchTermsByBook($termsToSearch, $book, $page = 1, $rowsPerPage) { 
    //$book = livro_slug
    if($page > 1):
      $startRow = ($page - 1) * $rowsPerPage;
    else:
      $startRow = 0;
    endif;

    $query = "SELECT livro_nome,
                      cap, 
                      ver, 
                      texto,
                      livro_slug,
                      MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) 
                      AS SCORE 
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    AND livro_slug = :book
    LIMIT $startRow,$rowsPerPage";

		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':terms', $termsToSearch);
		$statement->bindValue(':book', $book);
		$statement->execute();
		return $statement->fetchAll();
  }


  public static function searchTermsByTestament($termsToSearch, $testament, $page = 1, $rowsPerPage) { 

    if($page > 1):
      $startRow = ($page - 1) * $rowsPerPage;
    else:
      $startRow = 0;
    endif;

    $query = "SELECT livro_nome,
                      cap, 
                      ver, 
                      texto,
                      testamento,
                      livro_slug,
                      MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) 
                      AS SCORE 
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    AND testamento = :testament
    LIMIT $startRow,$rowsPerPage";

		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':terms', $termsToSearch);
		$statement->bindValue(':testament', $testament);
		$statement->execute();
		return $statement->fetchAll();
  }
  

  public static function totalRowsByBooks($termsToSearch) {
    // ALL BOOKS
    $query = "SELECT  livro_nome,
                      livro_slug,
                      COUNT(*) AS TOTAL
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    GROUP BY bl.id";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->execute();
    return $statement->fetchAll();
  }


  public static function totalRowsByTestament($termsToSearch) {
    // ALL TESTAMENT
    $query = "SELECT  testamento,
                      COUNT(*) AS TOTAL
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    GROUP BY bl.testamento DESC";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->execute();
    return $statement->fetchAll();
  }


  public static function totalRowsByOneBook($termsToSearch, $bookSlug) {
    // UNIQUE BOOK
    $query = "SELECT  livro_nome,
                      livro_slug,
                      COUNT(*) AS TOTAL
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    AND livro_slug = :book_slug
    GROUP BY bl.id";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->bindValue(':book_slug', $bookSlug);
    $statement->execute();
    return $statement->fetchAll();
  }


  public static function totalRowsByOneTestament($termsToSearch, $testament) {
    // UNIQUE TESTAMENT
    $query = "SELECT  testamento,
                      COUNT(*) AS TOTAL
    FROM bibliakja AS biblia
    LEFT JOIN biblia_livros AS bl
    ON bl.cod_livro = biblia.cod_livro
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0
    AND testamento = :testament
    GROUP BY bl.testamento";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->bindValue(':testament', $testament);
    $statement->execute();
    return $statement->fetchAll();
  }


  public static function totalRows($termsToSearch) {

    $query = "SELECT COUNT(cod_livro) AS TOTAL
    FROM bibliakja
    WHERE MATCH (texto) AGAINST (:terms IN BOOLEAN MODE) > 0";

    $connection = Connect::getConnection();
    $statement = $connection->prepare($query);

    $statement->bindValue(':terms', $termsToSearch);
    $statement->execute();
    return $statement->fetch();
  }


  public function paginationLinks($totalPages, $pagesStart, $pagesMid, $pagesEnd, $pageSelected, $terms, $bookSelected, $testamentSelected) {
    $allLinksTogether = "";
    $linkCreated = "";

    // CONSTRUCT PAGINATION AND 
    // HIGHLIGHT THE SELECTED ONE
    foreach ($pagesStart as $pages):
      $linkCreated = $this->paginationLinksCreator($terms, $pages, $pageSelected, $bookSelected, $testamentSelected);

      $allLinksTogether = $allLinksTogether . $linkCreated;

      //$allLinksTogether = $allLinksTogether . "<a href='/pesquisa.php?termos=$terms&pagina=$pages' class='pagination--number'>$pages</a>";
    endforeach;

    if (!empty($pagesMid)):
      $allLinksTogether = $allLinksTogether . " ... ";

      foreach ($pagesMid as $pages):
        $linkCreated = $this->paginationLinksCreator($terms, $pages, $pageSelected, $bookSelected, $testamentSelected);

        $allLinksTogether = $allLinksTogether . $linkCreated;

        //$allLinksTogether = $allLinksTogether . "<a href='/pesquisa.php?termos=$terms&pagina=$pages' class='pagination--number'>$pages</a>";
      endforeach;

      //echo implode(" ", $pagesStart) . " ... " . implode(" ", $pagesMid) . " ... " . implode(" ", $pagesEnd);
    endif;
    
    if (!empty($pagesEnd)):
      $allLinksTogether = $allLinksTogether . " ... ";

      foreach ($pagesEnd as $pages):
        $linkCreated = $this->paginationLinksCreator($terms, $pages, $pageSelected, $bookSelected, $testamentSelected);

        $allLinksTogether = $allLinksTogether . $linkCreated;
        
        //$allLinksTogether = $allLinksTogether . "<a href='/pesquisa.php?termos=$terms&pagina=$pages' class='pagination--number'>$pages</a>";
      endforeach;
      //echo implode(" ", $pagesStart) . " ... " . implode(" ", $pagesEnd);
    endif;
    
    //echo "<a href='/pesquisa.php?termos=$terms&pagina=$i' class='pagination--number'>$i</a>";


    return $allLinksTogether;
  }

  private function paginationLinksCreator($terms, $pages, $pageSelected, $bookSelected = "", $testamentSelected = "") {
    // if ($pageSelected != $pages):
    //   $linkCreated = paginationLinksCreator($terms, $pages);
    // else:
    //   $linkCreated = paginationLinksCreator($terms, $pages, true);
    // endif;
    if ($bookSelected <> ""):
      return ($pageSelected != $pages) ? 
      // common link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages&livro=$bookSelected' class='pagination--number'>$pages</a>": 
      // selected link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages&livro=$bookSelected' class='pagination--number pagination--number__selected'>$pages</a>";
    
    elseif ($testamentSelected <> ""):
      return ($pageSelected != $pages) ? 
      // common link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages&testamento=$testamentSelected' class='pagination--number'>$pages</a>": 
      // selected link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages&testamento=$testamentSelected' class='pagination--number pagination--number__selected'>$pages</a>";

    else:
      return ($pageSelected != $pages) ? 
      // common link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages' class='pagination--number'>$pages</a>": 
      // selected link
      "<a href='/pesquisa.php?termos=$terms&pagina=$pages' class='pagination--number pagination--number__selected'>$pages</a>";
    endif;
  }

  public function highlightWords($text, $terms){
    $terms = implode('|', explode(' ', preg_quote($terms)));

    setlocale(LC_CTYPE, 'pt_BR');
    // Necessário para definir os acentos brasileiros

    return preg_replace("/($terms)/i", "<mark>$0</mark>", $text);
  }
}

?>