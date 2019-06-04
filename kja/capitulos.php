
<a href="/kja/<?= $book['livro_slug'] ?>/" aria-label="Ir para introdução de <?= $book['livro_nome'] ?>" class="entry-title-wrapper is-sticky has-tooltip--toright">
  <h1 class="entry-title"><?= ($bookWithNoSpace = str_replace(' ', '', $book['livro_nome'])) . ' ' . $chapter['cap']; ?></h1>
</a>
  <!-- <p class="breadcrumb-meta">
    <small>
      <a href="#">Estudo Bíblico</a> > <a href="#">Gênesis</a>
    </small>
  </p> -->
<!-- </hgroup> -->
<div class="entry-content">
  <p class="breadcrumb-meta">

    <?php // if () ACRESCENTAR O LINK DA INTRODUCAO DO CAPITULO?>

    <small>
      <a href="/">Início</a> &gt; 
      <a href="/kja/<?= $book['livro_slug']; ?>"><?= $book['livro_nome']; ?></a> &gt; 
      <strong>Cap. <?= $chapter['cap']; ?></strong>
    </small>
  </p>
  
  <table class="tabela-versiculos">
<!-- 					<thead>
      <tr>
        <th>Versículos</th>							
        <th>Texto</th>
      </tr>
    </thead> -->
    <tbody>
      
      <?php 
        if (!empty($verses)):	
          foreach ($verses as $verse): 
            if (!is_null($verse['titulo'])):
      ?>
      
        <tr class="linha-titulo">
          <td colspan="2">
            <hgroup>
              <h3><?= $verse['titulo']; ?></h3>
              <h4><?= $verse['subtitulo']; ?></h4>
            </hgroup>
          </td>
        </tr>

      <?php endif; // titulo ?>

      <tr class="linha-conteudo ver-<?= $verse['ver']; ?>">
        <td class="linha-conteudo-ver"><?= $verse['ver']; ?></td>
        <td class="linha-conteudo-texto">
          <?= $verse['texto']; ?>
          <span class="linha-conteudo-refcruzada">

            <?php
              if (!empty($verse['referencias'])):
                $crossRefLinks = new CrossRef($verse['referencias']); 
              endif; 
            ?>

          </span>
        </td>
      </tr>

      <?php if (!is_null($verse['mais_info'])):	?>

        <tr class="linha-mais-info">
          <td colspan="2"><?= $verse['mais_info']; ?></td>
        </tr>							

      <?php
            endif; // mais_info
          endforeach;

          //if (!is_null($copy['copyright'])):
      ?>

        <tr class="biblia-copyright">
          <td colspan="2"><?= $copy['texto']; ?></td>
        </tr>

      <?php
        else:
      ?>

      <tr class="linha-conteudo">
        <td class="linha-conteudo-texto">Capítulo Inexistente. Livro de <?= $book['livro_nome'] ?> tem <?= $book['total_capitulos']?> capítulo(s). </td>
      </tr>

      <?php endif; ?>
      
    </tbody>
  </table>
  
</div>