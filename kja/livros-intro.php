<?php
	if (!empty($book) && isset($previousAndNext)):
?>

<div class="entry-title-wrapper is-sticky">
  <h1 class="entry-title">Introdução de <?= $bookWithNoSpace = str_replace(' ', '', $book['livro_nome']); ?></h1>
</div>

<?php endif; ?>

<div class="entry-content">
  <p class="breadcrumb-meta">

    <small>
      <a href="/">Início</a> &gt; 
      <?= $book['livro_nome'] ?></strong>
    </small>
  </p>
  
  <table class="tabela-livro-intro">
    <tbody>
      
        <tr class="linha-conteudo">
          <td class="linha-conteudo-intro"><?= $book['livro_intro'] ?></td>
        </tr>
      
    </tbody>
  </table>
  
</div>