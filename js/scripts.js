//******************
// main mobile menu toggle
//******************
const navbarMobileMenu = () => {
	const buttonX = document.querySelector('.button-x');
	const buttonBars = document.querySelector('.button-bars');
	const activeToggle = document.querySelector('.nav-menu');

	buttonX.classList.toggle('button-toggle');
	buttonBars.classList.toggle('button-toggle');
	
	if (activeToggle.classList.contains('nav-menu-hidden')) {
		activeToggle.style.display = "block";
		setTimeout(function() {
			activeToggle.classList.toggle('nav-menu-hidden');
		}, 100);
	} else {
		activeToggle.classList.toggle('nav-menu-hidden');
		setTimeout(function() {
			activeToggle.style.display = "none";
		}, 300);
	}
};

document.querySelector('.navbar-toggler').addEventListener('click', navbarMobileMenu); // call after assign the variable


//******************
// scroll to top
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

// scroll to the top of the document when click the button
const toTop = () => {
	const docScrolled = document.body.scrollTop || document.documentElement.scrollTop; // body FOR SAFARI, documentElement FOR CHROME, FIREFOX, IE and OPERA

	if (docScrolled != 0) {
		window.requestAnimationFrame(toTop);
		window.scrollTo(0, docScrolled - docScrolled / 10); // goes smoothie to top 
		// console.log(docScrolled - docScrolled / 8);
	}
}

document.querySelector('.scroll-top').addEventListener('click', toTop); // call after assign the variable


// activate functions when scrolling
window.onscroll = () => { 
	detectScroll(200, ".scroll-top", "scroll-top-hidden", true);
	detectScroll(39, "#header", "header-changed", false);


	//stop point height
	const stopPoint = document.querySelector(".divider-bar").offsetTop;
	//nav buttons
	const leftBtn = document.getElementById("chapter-nav-left");
	const rightBtn = document.getElementById("chapter-nav-right");
	const scrollTop = document.querySelector(".scroll-top");
	
	stickyEl(stopPoint, leftBtn, 10); //stopPoint, targetEl, positionEl = css position bottom
	stickyEl(stopPoint, rightBtn, 10); 
	// stickyEl(stopPoint, scrollTop, 70); //allow to go to the end
}


//******************
// navigation buttons left/right
//******************

const stickyEl = (stopPoint, targetEl, positionEl = 0) => {
	//height when scrolling
	const docScrolled = document.body.scrollTop || document.documentElement.scrollTop;
	
	//element height + position bottom
	const targetOffset = targetEl.clientHeight + positionEl;
	
	//view port height
	const h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0) - targetOffset;
	const w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

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
// modal
//******************
const modalBg = document.getElementById('modal-bg');
const capitulosBtn = document.querySelector('.capitulos-btn');

function modalEvent() {
	document.getElementById('nav-bible').classList.toggle('nav-bible-slide-in');
	
	modalBg.style.display = modalBg.style.display === 'none' ? 'block' : 'none';
}

capitulosBtn.addEventListener('click', () => modalEvent());

// close the modal when click anywhere outside the modal
window.onclick = function(event) {
  if (event.target == modalBg) { modalEvent() };
}


//******************
// external links
//******************
const externalLink = document.querySelectorAll('a.external-link');

externalLink.forEach(el => {
	el.setAttribute('rel', 'noopener',);
	el.setAttribute('target', '_blank');
});


//******************
// active buttons deactivation
//******************
const deactivateButton = () => {
	let pathURI = window.location.pathname;
	pathURI = pathURI.replace(/\/$/, ""); //exclude the last slash symbol
	pathURI = decodeURIComponent(pathURI); //make sure to get it decoded (like we see)

	const bookBtn = document.querySelectorAll(".book-btn");

	bookBtn.forEach(btn => {
		let hrefBtn = btn.getAttribute("href"); //returns the pathURI from element
		if (hrefBtn === pathURI) {
			btn.classList.add("deactivated");
		}
	});
}

deactivateButton();