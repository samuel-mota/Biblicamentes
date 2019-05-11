<?php

class Study {
	// public $biblia_versao;
	
 	// public function __construct($biblia_versao) {
 		
	// 	//if ($biblia_versao == 'kja'):
	// 		$this->biblia_versao = $biblia_versao;
	// 	//endif;
 	// }
	
// JÁ ESTA FUNCIONANDO
// 	public function getVerses() {
// 		$query = "SELECT ver, texto FROM biblicamentes.bibliakja WHERE cod_livro LIKE 'gnx030%'";
// 		$connection = Connect::getConnection();
		
// 		$result = $connection->query($query);
// 		$verses = $result->fetchAll();	
// 		return $verses;
// 	}

	public static function getChapterContent($biblia_versao, $livro_slug, $cap) {

		//modificar quando adicionar mais uma versao biblica
		$biblia_versao = 'bibliakja';

		$query = "SELECT 	bt.titulo, 
											bt.subtitulo, 
											bv.cap, 
											bv.ver,
											bv.texto, 
											bm.mais_info,
											bl.livro_nome,
											bl.livro_slug,
											brc.referencias
							FROM $biblia_versao AS bv 
							LEFT JOIN biblia_maisinfo AS bm ON bv.cod = bm.cod_biblia 
							LEFT JOIN biblia_titulos AS bt ON bv.cod = bt.cod_biblia
							LEFT JOIN biblia_livros AS bl ON bv.cod_livro = bl.cod_livro 
							LEFT JOIN biblia_refcruz AS brc ON bv.cod = brc.cod_biblia 
							WHERE bl.livro_slug = :livro_slug
							&& bv.cap = :cap";
		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':livro_slug', $livro_slug);
		$statement->bindValue(':cap', $cap);
		$statement->execute();
		//return $statement->fetchAll();	
		$verses = $statement->fetchAll();	
		return $verses;
	}

	public static function getCopyright ($biblia_versao) {
		//modificar quando adicionar mais uma versao biblica
		$biblia_versao = 'bibliakja';

		$query = "SELECT texto
							FROM $biblia_versao
							WHERE cod = 'copyright'";
		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->execute();
		$copy = $statement->fetch();	
		return $copy;
	}
	
	public static function getBook($livro_slug) {
		$query = "SELECT 	bl.id, 
											bl.livro_nome,
											bl.livro_slug,
											bl.livro_abreviado,
											bv.ver,
											bv.cap, 
											bl.total_capitulos,
											bl.livro_intro
							FROM biblia_livros AS bl 
							LEFT JOIN bibliakja AS bv ON bl.cod_livro = bv.cod_livro
							WHERE bl.livro_slug = :livro_slug
							LIMIT 1";
		$connection = Connect::getConnection();
		
		$statement = $connection->prepare($query);
		$statement->bindValue(':livro_slug', $livro_slug);
		$statement->execute();
		$book = $statement->fetch();
		return $book;
		
		// o mesmo que: 
		// return $chapter = Connect::getConnection()->query("SELECT cap FROM biblicamentes.bibliakja WHERE cod_livro LIKE '01gnx030%'")->fetch();
	}

	public static function getChapter($livro_slug, $cap) {
		$query = "SELECT 	bl.id, 
											bl.livro_nome,
											bl.livro_slug,
											bl.livro_abreviado,
											bv.ver,
											bv.cap, 
											bl.total_capitulos
							FROM biblia_livros AS bl 
							LEFT JOIN bibliakja AS bv ON bl.cod_livro = bv.cod_livro
							WHERE bl.livro_slug = :livro_slug 
							&& bv.cap = :cap
							LIMIT 1";
		$connection = Connect::getConnection();
		
		$statement = $connection->prepare($query);
		$statement->bindValue(':livro_slug', $livro_slug);
		$statement->bindValue(':cap', $cap);
		$statement->execute();
		$chapter = $statement->fetch();
		return $chapter;
	}
	
	//criar os botoes com os nomes dos livros, e tambem dos capitulos
	public static function getBooksAll($testament = "") {
		if ($testament == "velho" || $testament == "novo"): // show by testament
			$query = "SELECT 	livro_nome,
												livro_slug,
												testamento 
							FROM biblia_livros
							WHERE testamento = :testament;";
		else: // show all
			$query = "SELECT 	livro_nome,
												livro_slug,
												testamento 
							FROM biblia_livros";
		endif;
		$connection = Connect::getConnection();
		$statement = $connection->prepare($query);

		$statement->bindValue(':testament', $testament);
		$statement->execute();
		$books = $statement->fetchAll();	
		return $books;
	}

	public static function getPreviousAndNextBooks($currBook) { //getBookAndChapter()

		if ($currBook == 1): //GENESIS
			$next = 2;
			$prev = 66;
		elseif ($currBook == 66): //APOCALIPSE
			$next = 1;
			$prev = 65;
		else: // BOOKS LEFT
			$next = $currBook + 1;
			$prev = $currBook - 1;
		endif;

		$query = "SELECT 	id, 
											livro_nome, 
											livro_slug,
											total_capitulos
							FROM biblia_livros
							WHERE id = $prev
							OR id = $next
							OR id = :currbook
							ORDER BY FIELD(id, $prev, $next, :currbook)";
		
		$connection = Connect::getConnection();
		
		$statement = $connection->prepare($query);
		//$statement->bindValue(':previd', $prev);
		$statement->bindValue(':currbook', $currBook);
		//$statement->bindValue(':nextid', $next);
		$statement->execute();
		$previousAndNext = $statement->fetchAll();
		return $previousAndNext;
	}

	public static function getRandomVerses() {
		$query = "SELECT 	brv.id,
											brv.texto, 
											brv.cap, 
											brv.ver, 
											brv.livro_nome,
											bl.livro_slug
							FROM biblia_random_verses AS brv
							JOIN biblia_livros AS bl
							ON brv.cod_livro = bl.cod_livro";
		$connection = Connect::getConnection();

		$statement = $connection->prepare($query);
		$statement->execute();
		$randomVerses = $statement->fetchAll();
		return $randomVerses;
	}
}
?>