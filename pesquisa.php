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
    //transform characters in html notation
    //$terms = htmlspecialchars($_GET['termos'], ENT_QUOTES, 'UTF-8'); 

    // remove some extra characters
    $terms = preg_replace('/[^0-9A-Za-zÀ-ú ]/', '', $_GET['termos']);

    if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"]) && $_GET["pagina"] >= 1): //is_int retorna false :(
      $pageSelected = $_GET["pagina"];
    else:
      $pageSelected = 1;
    endif;

    if (isset($_GET["livro"]) && !empty($_GET["livro"])):
      $bookSelected = $_GET["livro"];
    else:
      $bookSelected = "";
    endif;

    if (isset($_GET["testamento"]) && !empty($_GET["testamento"])):
      $testamentSelected = $_GET["testamento"];
    else:
      $testamentSelected = "";
    endif;

	} catch (Exception $e) {
		echo ('MENSAGEM:' . $e->getMessage());
	}
	
?>
	
  <section class="content l-container">
    <header class="content--center">
      <i class="fas fa-search fa-7x page__main-icon"></i>
      <h1>Resultados da Pesquisa</h1>

    <?php 
      //echo $pageSelected;
      $rowsPerPage = 20;
      $minChar = 3;

      if (strlen($terms) < $minChar || empty($terms)):
        echo "<p>Termo muito curto, palavra deve conter pelo menos $minChar caracteres</p>";
        
        echo "</header></section>";

      else:

// SEARCH BY BOOK / TESTAMENT / ALL
// SEE PAGINATION
        if ($bookSelected <> ""):
          $search = Search::searchTermsByBook($terms, $bookSelected, $pageSelected, $rowsPerPage);
        elseif ($testamentSelected <> ""):
          $search = Search::searchTermsByTestament($terms, $testamentSelected, $pageSelected, $rowsPerPage);
        else:
          $search = Search::searchTerms($terms, $pageSelected, $rowsPerPage);
        endif;

        if (count($search) == 0):
          echo "<p>Desculpe, não encontramos nenhum versículo correspondente para o(s) termo(s) &quot;<strong>$terms</strong>&quot;.</p>
          <h4>Veja algumas dicas:</h4>
          <ol style='text-align: left;'>
          <li>Tente palavras chaves. Por exemplo: Se você quiser procurar <i>&quot;onde está escrito sobre o Monte Sinai&quot;</i> use somente &quot;<i>Monte Sinai</i>&quot;</li>
          <li>Tente palavras diferentes com significados parecidos.</li>
          <li>Por favor verifique a ortografia.</li></ol>";

          echo "</header></section>";

        else:
          echo "<p>Você procurou por &quot;<strong>$terms</strong>&quot;</p>";

          if ($bookSelected <> ""): 
            echo "<p>No livro de <strong>" . $search[0]["livro_nome"] . "</strong></p>"; 
          endif;

          echo "<hr size='1'>";
          echo "</header>";
    ?>


    <article class="content content__search content--row">

      <section class="searched-terms">

        <?php 
        $count = 0;

        $highlightWords = new Search();


        foreach($search as $term): 
          $count += 1; 
        ?>

        <p class="search-terms__verse term__number-<?= $count ?>">

          <a class="main__link--bold" href="/kja/<?= $term['livro_slug']; ?>/<?= $term['cap'] ?>/">
            <?= $term['livro_nome']; ?>&nbsp;<?= $term['cap']; ?>:<?= $term['ver']; ?>
          </a>

          <?php echo $highlightWords->highlightWords($term['texto'],$terms); ?>

        </p>

      <?php endforeach; ?>

      </section>

      <aside class="aside-nav js-aside-modal">
        <button type="button" class="aside-nav__button js-aside-button" aria-label="Busca por livros">Livros</button>

        <div class="aside-nav__bible--search">
        
          <h3 class="aside-nav__bible--intro">Termos encontrados na Bíblia</h3>

<!-- ROWS BY TESTAMENTS / BOOKS -->
          <table>

          <?php 
          $totalRowsByTestament = Search::totalRowsByTestament($terms);

          $totalRowsByBooks = Search::totalRowsByBooks($terms);

          foreach ($totalRowsByTestament as $row): 
            if ($row["testamento"] === "velho"):
              $testamentName = "Velho Testamento";
            else:
              $testamentName = "Novo Testamento";
            endif; ?>

                <tr>
                  <td class="main__link--testament"><a class="main__link--bold" href="/pesquisa.php?termos=<?= $terms ?>&testamento=<?= $row['testamento']; ?>"><?= $testamentName ?></a></td>
                  <td class="main__link--testament"><?= $row['TOTAL'] ?></td>
                </tr>

          <?php endforeach;

          foreach ($totalRowsByBooks as $row): 
          ?>
            
              <tr>
                <td><a class="main__link--bold" href="/pesquisa.php?termos=<?= $terms ?>&livro=<?= $row['livro_slug']; ?>"><?= $row['livro_nome']; ?></a></td>
                <td><?= $row['TOTAL'] ?></td>
                <!-- <td><= $row['livro_nome'] ?></td>
                <td><= $row['TOTAL'] ?></td> -->
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
    if ($bookSelected === "") :

    else:

    endif;
// PAGINATION FOR UNIQUE BOOK / UNIQUE TESTAMENT / ALL
    if ($bookSelected <> ""):
      $rowsSelected = Search::totalRowsByOneBook($terms, $bookSelected);
      $totalRows = $rowsSelected[0]["TOTAL"];
    elseif ($testamentSelected <> ""):
      $rowsSelected = Search::totalRowsByOneTestament($terms, $testamentSelected);
      $totalRows = $rowsSelected[0]["TOTAL"];
    else:
      $rowsSelected = Search::totalRows($terms);
      $totalRows = $rowsSelected[0];
    endif;

    $totalPages = ceil($totalRows/$rowsPerPage);
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
      $paginationLinks = $pagination->paginationLinks($totalPages, $pagesStart, $pagesMid, $pagesEnd, $pageSelected, $terms, $bookSelected, $testamentSelected);

      echo $paginationLinks;

      //echo Search::paginationLinks($totalPages, $pagesStart, $pagesMid, $pagesEnd, $pageSelected, $terms);
      ?>
    </div>

    <?php endif; //(count($search) == 0)
      endif; //(strlen($terms) <= 1 || empty($terms))
        /*     
        - PAGINACAO
        - MOSTRAR QUANTOS VERSICULOS ENCONTRADOS 
        - INCLUIR CAIXAS DE SELECAO PARA QUANTIDADE DE ITENS MOSTRADOS
        ********************/
    ?>

  <?php require_once 'body__footer.php'; ?>