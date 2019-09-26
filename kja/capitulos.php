<a href="/kja/<?= $book['livro_slug'] ?>/" aria-label="Ir para introdução de <?= $book['livro_nome'] ?>"
  class="entry-title__link is-sticky">
  <h1 class="entry-title"><?= ($bookWithNoSpace = str_replace(' ', '', $book['livro_nome'])) . ' ' . $chapter['cap']; ?>
  </h1>
</a>

<div class="entry-content">
  <span class="breadcrumb-meta">
    <small>
      <a href="/">Início</a> &gt;
      <a href="/kja/<?= $book['livro_slug']; ?>"><?= $book['livro_nome']; ?></a> &gt;
      <strong>cap. <?= $chapter['cap']; ?></strong>
    </small>
  </span>

  <article class="entry-content__chapter">

    <?php 
        if (!empty($verses)):	
          foreach ($verses as $verse): 
            if (!is_null($verse['titulo'])):
      ?>

    <hgroup class="entry-content__titles">
      <h3 class="entry-content__title"><?= $verse['titulo']; ?></h3>
      <h4 class="entry-content__subtitle"><?= $verse['subtitulo']; ?></h4>
    </hgroup>

    <?php endif; // titulo ?>

    <p id="<?= $verse['ver']?>" class="entry-content__verse verse-<?= $verse['ver']; ?>">
      <!-- linha-conteudo linha-conteudo-ver -->
      <sup class="entry-content__verse--number"><?= $verse['ver']; ?></sup>
      <!-- <td class="linha-conteudo-texto"> -->

      <?= $verse['texto']; ?>

      <span class="entry-content__verse--cross-ref">

        <?php
            if (!empty($verse['referencias'])):
              $crossRefLinks = new CrossRef($verse['referencias']); 
            endif; 
          ?>

      </span>
      <!-- </td> -->
    </p>

    <?php if (!is_null($verse['mais_info'])):	?>

    <p class="entry-content__verse--more-info">
      <?= $verse['mais_info']; ?>
    </p>

    <?php
            endif; // mais_info
          endforeach;

          //if (!is_null($copy['copyright'])):
      ?>

    <article class="entry-content__copyright">
      <?= $copy['texto']; ?>
    </article>

    <?php
        else:
      ?>

    <div class="content__error">
      Capítulo Inexistente. Livro de <?= $book['livro_nome'] ?> tem <?= $book['total_capitulos']?> capítulo(s).
    </div>

    <?php endif; ?>

    <!-- </tbody> -->
  </article>

</div>