<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<title>Biblicamentes</title>
	<link rel="stylesheet preload" href="/css/styles.css" as="style">
	
<?php 
	require_once 'html__head.php';
	require_once 'body__header.php';
	require_once 'classes/load-classes.php';

	try {

		$randomVerses = Study::getRandomVerses();

	} catch (Exception $e) {
		echo ('MENSAGEM:' . $e->getMessage());
	}
	
?>
	
	<section class="content content--center content--row l-container">
		
		<!-- VERSICULOS ALEATÓRIOS -->
		<article class="content__random-verses">
			
			<?php foreach ($randomVerses as $randomVerse): ?>
			
				<div class="content__random-verse<?= $randomVerse['id'] ?>">
					<div class="content__random-verse--text">
						
						<?= $randomVerse['texto']; ?>

					</div>
					<div class="content__random-verse-link">
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
		<article class="content__instagram-feed">

			<script src="https://assets.juicer.io/embed.js" type="text/javascript"></script>
			<link href="https://assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
			<ul class="juicer-feed" data-feed-id="biblicamentes" data-pages="1" data-per="1" data-gutter="200"><h1 class="referral"><a href="https://www.juicer.io">Powered by Juicer</a></h1></ul>

			<a href="https://www.instagram.com/biblicamentes" title="Siga-nos no Instagram!" class="instagram-follow-btn js-external-link"><i class="fab fa-instagram"></i> Siga-nos no Instagram!</a>

		</article>
	</section> 

<?php require_once 'body__footer.php' ?>