<?php 
	require_once 'load-classes.php';

	//https://www.w3schools.com/pHP/php_exception.asp
	//https://www.php.net/manual/en/language.exceptions.php
	//https://www.php.net/manual/en/internals2.opcodes.catch.php
 	try {
		$bibliaVersao = $_GET['biblia_versao'];
		$livroSlugCurr = $_GET['livro_slug'];

		if (isset($_GET['livro_slug']) && !empty($_GET['livro_slug']) && isset($_GET['cap']) && !empty($_GET['cap'])):

			$cap = $_GET['cap'];
			$verses = Study::getChapterContent($bibliaVersao, $livroSlugCurr, $cap);
			$chapter = Study::getChapter($livroSlugCurr, $cap);
			$copy = Study::getCopyright($bibliaVersao);

		//elseif (isset($_GET['livro_slug']) && !empty($_GET['livro_slug']) && !isset($_GET['cap'])):

			//$cap = 1;

		endif;

		$book = Study::getBook($livroSlugCurr);

		if ($book['id'] > 0 && $book['id'] <= 66):
			$previousAndNext = Study::getPreviousAndNextBooks($book['id']); //[0] previous book, [1] next book, [2] current book
		endif;

		$books = Study::getBooksAll(); //show all

 	} catch (Exception $e) {
 	 	echo ('MENSAGEM: ' . $e->getMessage());
 	}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<title><?= $book['livro_nome'] ?> * Biblicamentes</title>
	
	<!--device-width = abrir com o tamanho da tela do aparelho; initial-scale=1 = escala padrão 1 do dispositivo-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="BiblicaMentes, ler, meditar, estudar a palavra de Deus.">
	<meta name="keywords" CONTENT="Biblicamentes, Bíblia, Jesus, Deus">
	<meta name="author" content="Copyright © 2018 - biblicamentes.com.br">
	<meta name="robots" CONTENT="index, follow, all">
	
	<!-- BEGIN CSS TEMPLATE -->
	<link rel="icon" href="/favicon.png">
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/books.css">
	<!-- END CSS TEMPLATE -->
</head>


<?php require_once 'header.php'; ?>


	<div class="scroll-top scroll-top-hidden btn-style-regular"></div>

	<section id="content" class="container">

		<!-- CONTEUDO DO LIVRO  -->
		<main class="main-content">

		<?php if (!empty($book)):	?>

			<?php
				//call capitulos.php if both $_GET is set
				//call livros.php if only livro_slug is set
				if (isset($_GET['livro_slug']) && isset($_GET['cap'])):

					require_once 'capitulos.php';

				elseif (isset($_GET['livro_slug']) && !isset($_GET['cap'])):

					require_once 'livros-intro.php';

				endif;
			
			else:	?>

			<tr class="linha-conteudo">
				<td class="linha-conteudo-texto">Livro Inexistente. Use o menu e navegue entre os livros.</td>
			</tr>

			<?php endif; //!empty $book ?>

		</main>

		<?php if (!empty($book)):	?>

		<div id="modal-bg" style="display: none;"></div>

		<aside id="nav-bible">
			<button type="button" class="modal-btn capitulos-btn btn-style-regular">Capítulos</button>
			<div class="nav-bible-wrapper">
				<div class="nav-chapters">
					<!-- CURRENT BOOK -->
					<h3><a class="book-btn" href="/kja/<?= $previousAndNext[2]['livro_slug'] ?>">Introdução <?= $previousAndNext[2]['livro_nome'] ?></a></h3>

					<?php for ($i = 1; $i < $book['total_capitulos'] + 1; $i++): ?>
						
						<a class="book-btn" href="/kja/<?= $book['livro_slug'] ?>/<?= $i ?>"><?= $i ?></a>
						
					<?php endfor; ?>

				</div>

				<div class="nav-books">
					<p>
					<!-- PREVIOUS BOOK -->
						<a class="book-btn" href="/kja/<?= $previousAndNext[0]['livro_slug'] ?>"><i class="fas fa-chevron-left"></i> <?= $previousAndNext[0]['livro_nome'] ?></a>
					<!-- NEXT BOOK -->
						<a class="book-btn" href="/kja/<?= $previousAndNext[1]['livro_slug'] ?>"><?= $previousAndNext[1]['livro_nome'] ?> <i class="fas fa-chevron-right"></i></a>
					</p>
				</div>
			</div>
		</aside>
	</section> 


	<?php //previous and next buttons
		$totalCapsCurr = $book['total_capitulos'];
		
		if ((isset($livroSlugCurr) && !isset($cap)) || ($cap > 0 && $cap <= $totalCapsCurr)):
		
			$totalCapsPrev = $previousAndNext[0]['total_capitulos'];
			$totalCapsNext = $previousAndNext[1]['total_capitulos'];
			$totalCapsCurr = $previousAndNext[2]['total_capitulos'];
			$livroSlugPrev = $previousAndNext[0]['livro_slug'];
			$livroSlugNext = $previousAndNext[1]['livro_slug'];
			$livroNomePrev = $previousAndNext[0]['livro_nome'];
			$livroNomeNext = $previousAndNext[1]['livro_nome'];
			$livroNomeCurr = $previousAndNext[2]['livro_nome'];

			if (isset($cap)):
				//internal caps of the current book
				if ($cap > 1 && $cap < $totalCapsCurr):
					$prevBookName = $livroNomeCurr;
					$nextBookName = $livroNomeCurr;
					$prevBook = $livroSlugCurr;
					$nextBook = $livroSlugCurr;
					$prevCap = $cap - 1;
					$nextCap = $cap + 1;
				// books with only 1 cap, like judas
				elseif ($cap == 1 && $totalCapsCurr == 1): 
					$prevBookName = $livroNomeCurr;
					$nextBookName = $livroNomeNext;
					$prevBook = $livroSlugCurr;
					$nextBook = $livroSlugNext;
					$prevCap = "";
					$nextCap = "";
				// first cap
				elseif ($cap == 1): 
					$prevBookName = $livroNomeCurr;
					$nextBookName = $livroNomeCurr;
					$prevBook = $livroSlugCurr;
					$nextBook = $livroSlugCurr;
					$prevCap = "";
					$nextCap = $cap + 1;
				// last cap
				elseif ($cap == $totalCapsCurr):	
					$prevBookName = $livroNomeCurr;
					$nextBookName = $livroNomeNext;				
					$prevBook = $livroSlugCurr;
					$nextBook = $livroSlugNext;
					$prevCap = $cap - 1;
					$nextCap = "";
				endif;
			else:
				// book intro
				$prevBookName = $livroNomePrev;
				$nextBookName = $livroNomeCurr;
				$prevBook = $livroSlugPrev;
				$nextBook = $livroSlugCurr;
				$prevCap = $totalCapsPrev;
				$nextCap = 1;
			endif; //isset($cap)
	?>

	
		<a id="chapter-nav-left" class="btn-style-regular" href="/kja/<?= $prevBook ?>/<?= $prevCap ?>" title="<?php echo $prevBookName . " " . ($prevCap == "" ? "intro" : $prevCap); ?>"></a>

		<a id="chapter-nav-right" class="btn-style-regular" href="/kja/<?= $nextBook ?>/<?= $nextCap ?>" title="<?php echo $nextBookName . " " . ($nextCap == "" ? "intro" : $nextCap); ?>"></a>


	<?php 
			endif; //previous and next buttons 
		
		endif; //!empty $book	
	?>

	<div class="divider-bar"></div>


<?php require_once 'footer.php' ?>