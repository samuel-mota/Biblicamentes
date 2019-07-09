<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Pesquisa * Biblicamentes</title>
  <link rel="stylesheet preload" href="/css/styles.css" as="style">

  <?php 
	require_once 'html__head.php';
	require_once 'body__header.php'; 
	require_once 'classes/load-classes.php';

	try {
    //$button = $_GET [ 'submit' ]; 
    $terms = htmlspecialchars($_GET['termos'], ENT_QUOTES, 'UTF-8'); //transform characters in html notation

	} catch (Exception $e) {
		echo ('MENSAGEM:' . $e->getMessage());
	}
	
?>
	
  <section class="content l-container">
    <i class="fas fa-search fa-7x page__main-icon"></i>

    <h1>Resultados da Pesquisa</h1>

    <section class="search-terms">

    <?php 

      if (strlen($terms) <= 1) :
        echo "<p>Termo muito curto, palavra deve conter pelo menos 2 caracteres</p>"; 

      else :
        $search = Search::searchTerms($terms);
        //print_r($search);
        //var_dump($search);

        if (count($search) == 0) :
          echo "<p>Desculpe, não encontramos nenhum versículo correspondente para o(s) termo(s) <strong>$terms</strong>.</p>
          <h4>Veja algumas dicas:</h4>
          <ol style='text-align: left;'>
          <li>Tente palavras chaves. Por exemplo: Se você quiser procurar 'onde está escrito sobre o Monte Sinai' use somente 'Monte Sinai'</li>
          <li>Tente palavras diferentes com significados parecidos.</li>
          <li>Por favor verifique a ortografia.</li></ol>";

        else :
          echo "<p>Você procurou por <strong>$terms</strong></p> 
          <hr size='1'>";

          $count = 0;

          foreach($search as $term): 
            $count += 1; ?>

            <p class="search-terms__verse term__number-<?= $count ?>">

              <a class="main__link--bold" href="/kja/<?= $term['livro_slug']; ?>/<?= $term['cap'] ?>/">
                <?= $term['livro_nome']; ?>&nbsp;<?= $term['cap']; ?>:<?= $term['ver']; ?>
              </a>

              <?= $term['texto']; ?>

            </p>

        <?php endforeach;

          //$totalRowsByTestament = ;

          $totalRowsByBooks = Search::totalRowsByBooks($terms);
        ?>


    <aside class="aside-nav js-aside-modal">
			
			<button type="button" class="aside-nav__button js-aside-button" aria-label="Busca por livros">Livros</button>

			<div class="aside-nav__bible--search">
				
					<h3 class="aside-nav__bible--intro">Termos encontrados por livros</h3>

            <!-- ROWS BY BOOKS -->
          <table>

					<?php foreach ($totalRowsByBooks as $row): 
					?>
						
              <tr>
                <td><?= $row['livro_nome'] ?></td>
                <td><?= $row['TOTAL'] ?></td>
              </tr>

						<!-- <a class="bible__main-btn" href="/kja/< ?= //$book['livro_slug'] ?>/< ?= //$i ?>">< ?= //$i ?></a> -->
						
          <?php endforeach; ?>

          </table>

			</div>
		</aside>

    <!-- PAGINATION -->
    <?php 
      $totalRows = Search::totalRows($terms);
      //$totalPages = ceil($totalRows[0]/5);
      $totalPages = 2; //PARA TESTE******
      if(isset($_GET["pagina"])):
        $pageSelected = $_GET["pagina"];
      else:
        $pageSelected = 1;
      endif;
    ?>

    <div>
      <?php 
  //- ate 10
  //-- 1-10 paginas = 1 2 3 4 5 6 7 8 9 10
  //- acima de 10
  //-- 4 ... 4 = <<*1* 2 3 4 ... 8 9 10 11>>
  //-- 5 ... 4 = <<1 2 3 *4* 5 ... 8 9 10 11>>
  //-- 2...3...2 = <<1 2 ... 4 *5* 6 ... 10 11>>
  //-- 4 ... 5 = <<1 2 3 4 ... 7 *8* 9 10 11>>
  //-- 4 ... 4 = <<1 2 3 4 ... 8 *9* 10 11>>
    if ($totalPages <= 10):
      for ($i = 1; $i <= $totalPages; $i++): 
        echo $i . " ";
      endfor;
    else:
      $pagesStart = array();
      $pagesMid = array();
      $pagesEnd = array();
      $pagesAll = array();

      for ($i = 1; $i <= 4; $i++): 
        array_push($pagesStart, $i);
        array_unshift($pagesEnd, $totalPages--);
      endfor;

      // for ($i = $pageSelected; $i <= 3; $i++): 

      // endfor;


      //CRIAR LINKS COM FOREACH OU FOR
      echo implode(" ", $pagesStart) . " ... " . implode(" ", $pagesEnd);
    endif;
      ?>
    </div>


        <?php endif;

      endif;

/*     
- PAGINACAO
- MOSTRAR QUANTOS VERSICULOS ENCONTRADOS 
- INCLUIR CAIXAS DE SELECAO PARA QUANTIDADE DE ITENS MOSTRADOS
********************


        SELECT livro_nome, cap, ver, texto, livro_slug, 
MATCH (texto) AGAINST ("declarou então jesus") AS SCORE 
FROM bibliakja AS biblia
LEFT JOIN biblia_livros AS bl
ON bl.cod_livro = biblia.cod_livro
WHERE MATCH (texto) AGAINST ("declarou então jesus") > 0
LIMIT 0,10;

SELECT COUNT(*), 
MATCH (texto) AGAINST ("declarou então jesus") AS SCORE 
FROM bibliakja
WHERE MATCH (texto) AGAINST ("declarou então jesus") > 0; */
        


        
    ?>
		
    </section>

  </section>


  <?php require_once 'body__footer.php' ?>