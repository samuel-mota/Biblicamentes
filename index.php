<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<title>Biblicamentes</title>
	
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
	<!-- END CSS TEMPLATE -->
</head>

	
<?php
	require_once 'header.php'; 
	require_once 'load-classes.php';

	try {

		$randomVerses = Study::getRandomVerses();

	} catch (Exception $e) {
		echo ('MENSAGEM:' . $e->getMessage());
	}
	
?>
	
	<section id="content" class="container">
		
		<!-- VERSICULOS ALEATÓRIOS -->
		<article class="random-verses">
			
			<?php foreach ($randomVerses as $randomVerse): ?>
			
				<div class="random-verse<?= $randomVerse['id'] ?>">
					<div class="verse-text">
						
						<?= $randomVerse['texto']; ?>

					</div>
					<div class="verse-link">
						<a href="/kja/<?= $randomVerse['livro_slug']; ?>/<?= $randomVerse['cap'] ?>/">

							<?= $randomVerse['livro_nome']; ?>&nbsp;<?= $randomVerse['cap']; ?>:<?= $randomVerse['ver']; ?> KJA<br>
							ver contexto
						</a>
					</div>
				</div>
			
				<?php if ($randomVerse['id'] < count($randomVerses)): ?>

				<div class="divider"></div>

			<?php 
					endif;
				endforeach; 
			?>

		</article>

		<!-- INSTAGRAM FEED 
			adicionar data-pages="1" data-gutter="200" no <ul> -->
		<article class="instagram-feed">
			<script src="https://assets.juicer.io/embed.js" type="text/javascript"></script>
			<link href="https://assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
			<ul class="juicer-feed" data-feed-id="biblicamentes" data-pages="1" data-gutter="200"><h1 class="referral"><a href="https://www.juicer.io">Powered by Juicer</a></h1></ul>
			<a href="https://www.instagram.com/biblicamentes" target="_blank" title="Siga-nos no Instagram!" class="btn-follow-instagram"><i class="fab fa-instagram"></i> Siga-nos no Instagram!</a>
		</article>

		<!-- BIBLICAMENTES BOTÕES -->
<!-- 		<article class="biblicamentes-links">
			<div class="estudo-biblico-div">
				<a href="#" class="img-box">
					<img class="estudo-biblico-img" src="img/Estudo-Biblico.png" alt="Estudo Bíblico">
					<span>Tradução Bíblia King James Atualizada (KJA)</span>
				</a>
			</div>
			<div class="wiki-biblia-div">
				<a href="#" class="img-box">
				<img class="wiki-biblia-img" src="img/Wiki-Biblia.png" alt="Biblicamentes Wiki">
			</a>
			</div>
		</article> -->
	</section> 

<?php require_once 'footer.php' ?>