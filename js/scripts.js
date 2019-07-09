//******************
// MAIN MOBILE MENU TOGGLE
//******************
const opStart = 0.1;

const fadeOut = (el) => {
	let op = 1; // opacity
	if (bar1.classList.contains('bar1--move')) {
		bar1.classList.remove('bar1--move');
		bar2.classList.remove('bar2--move');
		bar3.classList.remove('bar3--move');
	} // to correct if someone click many times fast

	(function fadeOutAnimation() {
		if (op <= 0) {
			
			el.classList.add('is-hidden');
		} else {
			let opFixed = op.toFixed(2);
			//el.style.top = 53 + "px"; //check .navbar--mobile css
			el.style.transform = 'translateY(-10px)';
			el.style.opacity = opFixed; 
			requestAnimationFrame(fadeOutAnimation);
		}

		op -= opStart;
	})();
}

const fadeIn = (el) => {
	let op = 0; //opacity
	el.classList.remove('is-hidden');
	bar1.classList.add('bar1--move');
	bar2.classList.add('bar2--move');
	bar3.classList.add('bar3--move');

	(function fadeInAnimation() {
		if (op <= 1) {
			let opFixed = op.toFixed(2);
			//el.style.top = 63 + "px";
			el.style.transform = 'translateY(0px)';
			el.style.opacity = opFixed;
			requestAnimationFrame(fadeInAnimation);
		}

		op += opStart;
	})();
}

const mobileMenu = document.querySelector('.js-mobile-menu');
const btnMobileMenu = document.querySelector('.js-mobile-menu-btn');
const modalHeader = document.querySelector('.js-modal-header');
const bar1 = document.querySelector('.bar1');
const bar2 = document.querySelector('.bar2');
const bar3 = document.querySelector('.bar3');

btnMobileMenu.addEventListener('click', () => {
	if (mobileMenu.classList.contains('is-hidden')){
		fadeIn(mobileMenu);
		modalBgToggle();
		modalHeader.classList.add('is-modal');
	} else {
		fadeOut(mobileMenu);
		modalBgToggle();
		modalHeader.classList.remove('is-modal');
	}
});


//******************
// FUNCTION TO DETECT SCROLLING
//******************
const detectScroll = (pxDown, elementToSelected, classToggle, removeFirst) => {
	const elementSelected = document.querySelector(elementToSelected);
	const docScrolled = document.body.scrollTop || document.documentElement.scrollTop; // body FOR SAFARI, documentElement FOR CHROME, FIREFOX, IE and OPERA

	//change classes
  if (docScrolled > pxDown) { // in px
    if (removeFirst) {
    	elementSelected.classList.remove(classToggle);
    } else {
    	elementSelected.classList.add(classToggle);
    }
  } else {
    if (removeFirst) {
    	elementSelected.classList.add(classToggle);
    } else {
    	elementSelected.classList.remove(classToggle);
    }
  }
}

//******************
// FUNCTION TO STICKY ELEMENTS
//******************
const stickyEl = (stopPoint, targetEl, positionEl = 0) => {
	//height when scrolling
	const docScrolled = document.body.scrollTop || document.documentElement.scrollTop;
	
	//element height + position bottom
	const targetOffset = targetEl.clientHeight + positionEl;
	
	//view port height
	const h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0) - targetOffset;
	//const w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

	// console.log(targetEl.clientHeight);
	// console.log(targetEl.offsetHeight);
	// console.log(w);

	//change to position ABSOLUTE when reaching stop point
	if ((docScrolled + h + targetOffset) >= stopPoint) {
		targetEl.style.position = 'absolute';
		targetEl.style.top = stopPoint - targetOffset + 'px';
	} else {
		targetEl.removeAttribute('style');
	}
}

//******************
// SCROLL TO TOP
//******************
// scroll to the top of the document when click the button
// const toTop = () => {
// 	const docScrolled = document.body.scrollTop || document.documentElement.scrollTop; // body FOR SAFARI, documentElement FOR CHROME, FIREFOX, IE and OPERA

// 	if (docScrolled != 0) {
// 		window.requestAnimationFrame(toTop);
// 		window.scrollTo(0, docScrolled - docScrolled / 10); // goes smoothie to top 
// 		console.log(docScrolled - docScrolled / 8);
// 	}

// 	window.scrollTo({
// 		top: 0,
// 		behavior: "smooth"
// 	});
// }
document.querySelector('.js-scrool-to-top').addEventListener('click', () => 
	window.scrollTo({
		top: 0,
		behavior: "smooth"
	})
);

//******************
// ELEMENTS BEHAVIOR ON SCROLLING
//******************
// activate functions when scrolling
window.onscroll = () => { 
	// DETECTSCROLL = pxDown, elementToSelected, classToggle, removeFirst
	//LEFT/RIGHT NAV BUTTONS
	detectScroll(200, ".scroll-top__button", "scroll-top__button--hidden", true);
	//HEADER 
	detectScroll(39, ".header", "is-header-hidden", false);

	//stop point height
	const stopPoint = document.querySelector(".footer").offsetTop;
	//nav buttons
	const leftBtn = document.querySelector(".js-chapter-nav--left");
	const rightBtn = document.querySelector(".js-chapter-nav--right");
	
	//stopPoint, targetEl, positionEl = css position bottom
	stickyEl(stopPoint, leftBtn, 10); 
	stickyEl(stopPoint, rightBtn, 10); 
}


//******************
// MODAL
//******************
const modalBg = document.querySelector('.js-modal-bg');

window.onclick = (event) => {	
	if (event.target == modalBg) { 
		// close modals when click anywhere outside the modal
		// close all elements linked to modal when modal is closed
		modalBg.classList.add('is-hidden');
		modalHeader.classList.remove('is-modal');
		mobileMenu.classList.add('is-hidden');

		if (modalAside) { // if element exists do
			modalAside.classList.remove('is-modal');
			modalAside.classList.remove('is-aside-nav--open'); 
		}

		fadeOut(mobileMenu);
	};
}

const modalBgToggle = () => {
	modalBg.classList.toggle('is-hidden');
}


//******************
// EXTERNAL LINKS
//******************
{
	const externalLink = document.querySelectorAll('.js-external-link');

	externalLink.forEach(el => {
		el.setAttribute('rel', 'noopener',);
		el.setAttribute('target', '_blank');
	});

//******************
// BOOK NAMES BUTTON DEACTIVATION
//******************
	let pathURI = window.location.pathname;
	const bookBtn = document.querySelectorAll(".bible__main-btn");

	pathURI = pathURI.replace(/\/$/, ""); //exclude the last slash symbol
	pathURI = decodeURIComponent(pathURI); //make sure to get it decoded (like we see)

	bookBtn.forEach(btn => {
		let hrefBtn = btn.getAttribute("href"); //returns the pathURI from element
		if (hrefBtn === pathURI) {
			btn.classList.add("is-inactive");
		}
	});
}


//******************
// ASIDE MENU NAVIGATION
//******************
const capitulosBtn = document.querySelector('.js-aside-button');
const modalAside = document.querySelector('.js-aside-modal');

capitulosBtn.addEventListener('click', () => {
  modalAside.classList.toggle('is-aside-nav--open');
  modalAside.classList.toggle('is-modal');

  modalBgToggle();
});

