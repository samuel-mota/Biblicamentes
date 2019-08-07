<body class="body">
<!-- BEGIN HEADER  -->
	<header class="header js-modal-header">
		<div class="header--top">
			<div class="navbar--top l-container">
			<!-- MENU TOP -->
				<ul class="nav-items">
					<li class="nav-item">
						<a href="https://www.facebook.com/biblicamentes" class="nav-link js-external-link"><i class="fab fa-facebook-f"></i></a>
					</li>
					<li class="nav-item">
						<a href="https://twitter.com/biblicamentes" class="nav-link js-external-link"><i class="fab fa-twitter"></i></a>
					</li>
					<li class="nav-item">
						<a href="https://www.instagram.com/biblicamentes" class="nav-link js-external-link"><i class="fab fa-instagram"></i></a>
					</li>
					<li class="nav-item">
						<a href="/contribua" class="nav-link">Contribua <i class="fas fa-donate"></i></a>
					</li>
					<li class="nav-item">
						<a href="/fale-conosco" class="nav-link">Fale Conosco <i class="far fa-envelope"></i></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="header--main">
			<nav class="navbar--main l-container">
				<a href="/" class="navbar__logo">
					<img src="/img/Biblicamentes-Logotipo-Oficial.svg" alt="Logo Biblicamentes" class="logo">
				</a>
	
				<!-- MOBILE MENU BUTTON -->
				<button type="button" class="navbar__button js-mobile-menu-btn">
					<span class="bars bar1"></span>
					<span class="bars bar2"></span>
					<span class="bars bar3"></span>
				</button> 
				
				<!-- MENU MOBILE FIRST -->
				<div class="navbar--mobile js-mobile-menu is-hidden"> <!-- smooth effect -->
					<ul class="nav-items">
						<li class="nav-item">
							<a href="/" class="nav-link">Início</a>
						</li>
						<li class="nav-item">
							<a href="/kja/gen/" class="nav-link">Estudo Bíblico</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link js-external-link">WikiBíblia <i class="fas fa-external-link-alt"></i></a>
						</li>
						<li class="nav-item">
							<a href="/contribua" class="nav-link">Contribua <i class="fas fa-donate"></i></a>
						</li>
						<li class="nav-item">
							<a href="/fale-conosco" class="nav-link">Fale Conosco <i class="far fa-envelope"></i></a>
						</li>
						<ul class="nav-items nav-items--social-mobile">
							<li class="nav-item">
								<a href="https://www.facebook.com/biblicamentes" class="nav-link nav-link--facebook js-external-link"><i class="fab fa-facebook-f"></i></a>
							</li>
							<li class="nav-item">
								<a href="https://twitter.com/biblicamentes" class="nav-link nav-link--twitter js-external-link"><i class="fab fa-twitter"></i></a>
							</li>
							<li class="nav-item">
								<a href="https://www.instagram.com/biblicamentes" class="nav-link nav-link--instagram js-external-link"><i class="fab fa-instagram"></i></a>
							</li>
						</ul>
					</ul>
				</div>

				<!-- MENU DESKTOP -->
				<div class="navbar--desktop js-desktop-menu">
					<ul class="nav-items">
						<li class="nav-item">
							<a href="/" class="nav-link">Início</a>
						</li>
						<li class="nav-item">
							<a href="/kja/gen/" class="nav-link">Estudo Bíblico</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link js-external-link">WikiBíblia <i class="fas fa-external-link-alt"></i></a>
						</li>
					</ul>
				</div>
					
				<!-- SEARCH -->
				<form class="search__form" action="/pesquisa.php" method="GET">
					<input class="search__input" type="search" placeholder="Pesquisar" name="termos">
					<button class="search__button" type="submit" name="pagina" value="1">
						<i class="fas fa-search"></i>
					</button>
				</form>

			</nav>
		</div>
	</header>

	<div class="is-modal__bg js-modal-bg is-hidden"></div>
	<!-- END HEADER  -->