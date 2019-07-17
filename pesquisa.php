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

    if(isset($_GET["pagina"]) && is_numeric($_GET["pagina"]) && $_GET["pagina"] >= 1): //is_int retorna false :(
      $pageSelected = $_GET["pagina"];
    else:
      $pageSelected = 1;
    endif;

	} catch (Exception $e) {
		echo ('MENSAGEM:' . $e->getMessage());
	}
	
?>
	
  <section class="content l-container">
    <i class="fas fa-search fa-7x page__main-icon"></i>
    <h1>Resultados da Pesquisa</h1>

    <?php 
      //echo $pageSelected;
      $rowsPerPage = 20;

      if (strlen($terms) <= 1 || empty($terms)):
        echo "<p>Termo muito curto, palavra deve conter pelo menos 2 caracteres</p>";

      else:
        $search = Search::searchTerms($terms, $pageSelected, $rowsPerPage);
        //print_r($search);
        //var_dump($search);

        if (count($search) == 0):
          echo "<p>Desculpe, não encontramos nenhum versículo correspondente para o(s) termo(s) <strong>$terms</strong>.</p>
          <h4>Veja algumas dicas:</h4>
          <ol style='text-align: left;'>
          <li>Tente palavras chaves. Por exemplo: Se você quiser procurar 'onde está escrito sobre o Monte Sinai' use somente 'Monte Sinai'</li>
          <li>Tente palavras diferentes com significados parecidos.</li>
          <li>Por favor verifique a ortografia.</li></ol>";

        else :
          echo "<p>Você procurou por <strong>$terms</strong></p> 
          <hr size='1'>";
    ?>

    <article class="content content--row">

      <section class="searched-terms">

        <?php 
        $count = 0;

        foreach($search as $term): 
          $count += 1; 
        ?>

        <p class="search-terms__verse term__number-<?= $count ?>">

          <a class="main__link--bold" href="/kja/<?= $term['livro_slug']; ?>/<?= $term['cap'] ?>/">
            <?= $term['livro_nome']; ?>&nbsp;<?= $term['cap']; ?>:<?= $term['ver']; ?>
          </a>

          <?= $term['texto']; ?>

        </p>

      <?php endforeach; ?>

      </section>

      <aside class="aside-nav js-aside-modal">
        <button type="button" class="aside-nav__button js-aside-button" aria-label="Busca por livros">Livros</button>

        <div class="aside-nav__bible--search">
        
          <h3 class="aside-nav__bible--intro">Termos encontrados por livro</h3>

            <!-- ROWS BY BOOKS -->
          <table>

          <?php 
          //$totalRowsByTestament = ;

          $totalRowsByBooks = Search::totalRowsByBooks($terms);

          foreach ($totalRowsByBooks as $row): 
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
    
    </article>
  </section>

  <div class="pagination">

    <?php // ********** PAGINATION ***********
    $totalRows = Search::totalRows($terms);

    $totalPages = ceil($totalRows[0]/$rowsPerPage);
    // FOR TEST ******
    //$totalPages = 10; 
    // ***************

    $pagesStart = array();
    $pagesMid = array();
    $pagesEnd = array();
    //$pagesAll = array();
    $numPagesEachSide = 4;

    //- up to 10 pages
    //-- 1-10 pages = 1 2 3 4 5 6 7 8 9 10
    if ($totalPages <= 10): 
      for ($i = 1; $i <= $totalPages; $i++): 
        array_push($pagesStart, $i);
        
        //echo $i . " ";
      endfor;
    else: 
      // more than 10 pages
      //-- 4 ... 4 = <<*1* 2 3 4 ... 8 9 10 11>>
      //-- 5 ... 4 = <<1 2 3 *4* 5 ... 8 9 10 11>>
      //-- 2...3...2 = <<1 2 ... 4 *5* 6 ... 10 11>>
      //-- 4 ... 5 = <<1 2 3 4 ... 7 *8* 9 10 11>>
      //-- 4 ... 4 = <<1 2 3 4 ... 8 *9* 10 11>>

      //**************************************
      // NEED IMPROVEMENT ********************
      //**************************************

      if($pageSelected <= $numPagesEachSide):
        for ($i = 1; $i <= $numPagesEachSide; $i++):
          array_unshift($pagesEnd, $totalPages--);
        endfor;

        if($pageSelected < $numPagesEachSide):
          for ($i = 1; $i <= $numPagesEachSide; $i++):
            array_push($pagesStart, $i);
          endfor;

        elseif ($pageSelected == $numPagesEachSide):
          for ($i = 1; $i <= ($numPagesEachSide + 1); $i++):
            array_push($pagesStart, $i);
          endfor;
        endif;

      elseif($pageSelected >= ($totalPages - $numPagesEachSide + 1)):
        for ($i = 1; $i <= $numPagesEachSide; $i++):
          array_push($pagesStart, $i);
        endfor;

        if($pageSelected > ($totalPages - $numPagesEachSide + 1)):
          for ($i = 1; $i <= $numPagesEachSide; $i++):
            array_unshift($pagesEnd, $totalPages--);
          endfor;

        elseif ($pageSelected == ($totalPages - $numPagesEachSide + 1)):
          for ($i = 1; $i <= ($numPagesEachSide + 1); $i++):
            array_unshift($pagesEnd, $totalPages--);
          endfor;
        endif;
      
      else:
        
        for ($i = 1; $i <= 2; $i++): // 2 pg each side
          array_push($pagesStart, $i);
          array_unshift($pagesEnd, $totalPages--);
        endfor;

        $count = $pageSelected - 1;
        for ($i = 1; $i <= 3; $i++): // 3 pg mid
          array_push($pagesMid, $count++);
        endfor;

      endif;

    endif; //if ($totalPages <= 10)

      // CONSTRUCT PAGINATION AND 
      // HIGHLIGHT THE SELECTED ONE

      $pagination = new Search();
      $paginationLinks = $pagination->paginationLinks($totalPages, $pagesStart, $pagesMid, $pagesEnd, $pageSelected, $terms);

      echo $paginationLinks;

      //echo Search::paginationLinks($totalPages, $pagesStart, $pagesMid, $pagesEnd, $pageSelected, $terms);
      ?>
    </div>

    <?php endif; //(count($search) == 0)
      endif; //(strlen($terms) <= 1)
        /*     
        - PAGINACAO
        - MOSTRAR QUANTOS VERSICULOS ENCONTRADOS 
        - INCLUIR CAIXAS DE SELECAO PARA QUANTIDADE DE ITENS MOSTRADOS
        ********************/
    ?>

  <?php require_once 'body__footer.php'; ?>