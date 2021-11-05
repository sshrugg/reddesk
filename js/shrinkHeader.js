/**
 * File customizer.js.
 *
 * Manages header size animations that occur when web page is scrolling
 * Selects all elements with the class .scrollShrink and adds the class .smaller
 * once the scrollbar reaches 50px
 * 
 */

function init() {
	window.addEventListener('scroll', function(){
		var distanceY = window.pageYOffset || document.documentElement.scrollTop,
			shrinkOn = 50,
			scrollShrink = document.querySelectorAll(".scrollShrink");
		if (distanceY > shrinkOn) {
			for (i = 0; i < scrollShrink.length; i++) { 
				scrollShrink[i].classList.add("smaller");
			}
		} else {
			if (scrollShrink[0].classList.contains("smaller")){
				for (i = 0; i < scrollShrink.length; i++) { 
					scrollShrink[i].classList.remove("smaller");
				}
			}
		}
	});
}
window.onload = init(); 