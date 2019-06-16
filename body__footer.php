<?php 
	
	require_once 'classes/load-classes.php';

	//https://www.w3schools.com/pHP/php_exception.asp
	//https://www.php.net/manual/en/language.exceptions.php
	//https://www.php.net/manual/en/internals2.opcodes.catch.php
 	try {

		$booksNew = Study::getBooksAll('novo');
		$booksOld = Study::getBooksAll('velho');

 	} catch (Exception $e) {

 	 	echo ('MENSAGEM: ' . $e->getMessage());
 	}

?>
	<!-- BEGIN FOOTER -->

	<div class="divider--bar"></div>

	<button type="button" class="scroll-top__button scroll-top__button--hidden has-tooltip--toright js-scrool-to-top" aria-label="Voltar ao Topo"><i class="fas fa-angle-up fa-2x"></i></button>
	
	<footer class="footer">
		<section class="footer__top l-container" >
			<div class="books-bible">
				<div class="books-bible__old">
					<h4 class="books-bible__title">Velho Testamento</h4>
					<div class="books-bible__buttons">

	 					<?php foreach ($booksOld as $bookOld): ?>

							<a class="bible__main-btn" href="/kja/<?= $bookOld['livro_slug'] ?>"><?= $bookOld['livro_nome'] ?></a>

						<?php endforeach; ?>

					</div>
				</div>
				<div class="books-bible__new">
					<h4 class="books-bible__title">Novo Testamento</h4>
					<div class="books-bible__buttons">
					
						<?php foreach ($booksNew as $bookNew): ?>

							<a class="bible__main-btn" href="/kja/<?= $bookNew['livro_slug'] ?>"><?= $bookNew['livro_nome'] ?></a>

						<?php endforeach; ?>

					</div>
				</div>
			</div>

			<div class="footer__top--nav">
				<a class="footer__link" href="/kja/gen/">
					<i class="fas fa-book fa-2x fa-pull-left fa-border"></i><strong>Estudo Bíblico</strong><br>
					<em>Leitura da Bíblia com Referências Cruzadas, Dicionário e links informativos. <br>
					<strong>Tradução Bíblia King James Atualizada (KJA)</strong></em>
				</a>
				<a class="footer__link js-external-link" href="#">
					<i class="fas fa-eye fa-2x fa-pull-left fa-border"></i> <strong>WikiBiblia</strong><br>
					<em>Informações extras para complementar sua leitura bíblica.</em>
				</a>
				<a class="footer__link" href="/contribua">
					<i class="fas fa-donate fa-2x fa-pull-left fa-border"></i> <strong>Contribua</strong><br>
					<em>Ajude-nos a manter o website!</em>
				</a>
				<a class="footer__link" href="/fale-conosco">
					<i class="far fa-envelope fa-2x fa-pull-left fa-border"></i> <strong>Fale Conosco</strong><br>
					<em>Envie-nos uma mensagem!</em>
				</a>
				<a class="footer__link" href="/fale-conosco">
					<i class="fas fa-bug fa-2x fa-pull-left fa-border"></i> <strong>Bug/Erros</strong><br>
					<em>Se encontrar algum erro/bug por favor nos avise!</em>
				</a>
			</div>
		</section>

		<section class="footer__bottom">
			<div class="footer__bottom--wrap l-container">
				<div class="footer__bottom--social">
					<a class="footer__bottom--social-link footer__bottom--facebook js-external-link" href="https://www.facebook.com/biblicamentes">
						<i class="fab fa-facebook-square"></i>
					</a>
					<a class="footer__bottom--social-link footer__bottom--twitter js-external-link" href="https://twitter.com/biblicamentes">
						<i class="fab fa-twitter-square"></i>
					</a>
					<a class="footer__bottom--social-link footer__bottom--instagram js-external-link" href="https://www.instagram.com/biblicamentes">
					<i class="fab fa-instagram"></i>
				</a>
				</div>
				<div class="copyright">
					Copyright © 2019 <strong>Biblicamentes</strong>. Todos os direitos reservados.
				</div>
			</div>
		</section>
	</footer>

	<script src="/js/scripts.js"></script>
	<script src="/js/scripts--biblia.js"></script>

</body>
</html>