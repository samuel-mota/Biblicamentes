<?php
	if (!empty($book) && isset($previousAndNext)):
?>

  <div class="entry-title__link is-sticky">
    <h1 class="entry-title">Introdução de <?= $bookWithNoSpace = str_replace(' ', '', $book['livro_nome']); ?></h1>
  </div>

<?php endif; ?>

<section class="entry-content">
  <span class="breadcrumb-meta">
    <small>
      <a href="/">Início</a> &gt; 
      <?= $book['livro_nome'] ?></strong>
    </small>
  </span>

  <article class="entry-content__intro">
    <!-- <p> class="tabela-livro-intro" -->
    <!-- <tr class="linha-conteudo"> -->
    <!-- <td class="linha-conteudo-intro"> -->
    <?= $book['livro_intro'] ?>
  </article>
</section>