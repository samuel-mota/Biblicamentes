<?php

class CrossRef {
    
  const pattern = '/([1-3]?[A-Za-zÀ-ú]+) ([0-9]+)\:([0-9]+)([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?([-|,][0-9]+)?/';
  public $refLinks;

  public function __construct($references) {

    $this->references = $references;
    $this->refLinks = $this->getCrossRefLinks($this->references);

    //echo '<pre>';
    echo $this->refLinks;
    //echo '</pre>';
  }

  public function getCrossRefLinks($references) {
    
    preg_match_all($this::pattern, $references, $refArr);
    $allLinksTogether = "";

    for ($i = 0; $i < count($refArr[0]); $i++):

      // array 1 = books name
      $bookName = $refArr[1][$i];
      $bookData = $this->getSlug($bookName);

      // array 2 = chapters
      $chapterNumber = $refArr[2][$i];

      // array 3 = verses
      $verseNumber = $refArr[3][$i];

      $allLinksTogether = $allLinksTogether . "<a href='/kja/" . $bookData[0] . "/" . $chapterNumber . "/' title='" . $bookName . "'>" . $bookData[1] . " " . $chapterNumber . ":" . $verseNumber . "</a> ";
    
    endfor;

    return $allLinksTogether;
  }

  private function getSlug($bookName) {
    $query = "SELECT livro_slug, livro_abreviado
              FROM biblia_livros
              WHERE livro_nome = :book_name";
    $connection = Connect::getConnection();
    
    $statement = $connection->prepare($query);
    $statement->bindValue(':book_name', $bookName);
    $statement->execute();
    return $statement->fetch();
  }
}

?>