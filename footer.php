<?php 
	
	require_once 'load-classes.php';

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
	
	<footer id="footer">
		<section id="footer-top" class="container" >
			<article class="books-nav">
				<div class="old-books">
					<h4>Velho Testamento</h4>
					<div class="old-book-links">

	 					<?php foreach ($booksOld as $bookOld): ?>

							<a class="book-btn" href="/kja/<?= $bookOld['livro_slug'] ?>"><?= $bookOld['livro_nome'] ?></a>

						<?php endforeach; ?>

					</div>
				</div>
				<div class="new-books">
					<h4>Novo Testamento</h4>
					<div class="new-book-links">
					
						<?php foreach ($booksNew as $bookNew): ?>

							<a class="book-btn" href="/kja/<?= $bookNew['livro_slug'] ?>"><?= $bookNew['livro_nome'] ?></a>

						<?php endforeach; ?>

					</div>
				</div>
			</article>

			<nav class="navbar-footer">
				<ul class="nav-items">
					<a href="/kja/gen/">
						<li>
							<i class="fas fa-book fa-2x fa-pull-left fa-border"></i><strong>Estudo Bíblico</strong><br>
							<em>Leitura da Bíblia com Referências Cruzadas, Dicionário e links informativos. <br>
							<strong>Tradução Bíblia King James Atualizada (KJA)</strong></em>
						</li>
					</a>
					<a href="#">
						<li>
							<i class="fas fa-eye fa-2x fa-pull-left fa-border"></i> <strong>WikiBiblia</strong><br>
							<em>Informações extras para complementar sua leitura bíblica.</em>
						</li>
					</a>
					<a href="/contribua">
						<li><i class="fas fa-donate fa-2x fa-pull-left fa-border"></i> <strong>Contribua</strong><br>
							<em>Ajude-nos a manter o website!</em>
						</li>
					</a>
					<a href="/fale-conosco">
						<li>
							<i class="far fa-envelope fa-2x fa-pull-left fa-border"></i> <strong>Fale Conosco</strong><br>
							<em>Envie-nos uma mensagem!</em>
						</li>
					</a>
					<a href="/fale-conosco">
						<li>
							<i class="fas fa-bug fa-2x fa-pull-left fa-border"></i> <strong>Bug/Erros</strong><br>
							<em>Se encontrar algum erro/bug por favor nos avise!</em>
						</li>
					</a>
				</ul>
			</nav>
		</section>

		<div id="footer-bottom">
			<div class="nav-social">
				<a href="https://www.facebook.com/biblicamentes" class="external-link link-facebook link-social">
					<i class="fab fa-facebook-f"></i>
				</a>
				<a href="https://twitter.com/biblicamentes" class="external-link link-twitter link-social">
					<i class="fab fa-twitter"></i>
				</a>
				<a href="https://www.instagram.com/biblicamentes" class="external-link link-instagram link-social">
					<i class="fab fa-instagram"></i>
				</a>
			</div>
			<div class="copyright">
				Copyright © 2019 <strong>Biblicamentes</strong>. Todos os direitos reservados.
			</div>
		</div>
	</footer>

	<!-- BEGIN JAVASCRIPT -->
	<script src="/js/jquery.js"></script>
	<script src="/js/scripts.js"></script>
	<!-- END JAVASCRIPT -->

</body>
</html>