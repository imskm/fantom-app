// Js for navmenu toggler
var nav_toggler = document.getElementById("navbar-toggler");

if (nav_toggler != null) {
	nav_toggler.addEventListener("click", function(e) {
		var navmenu = document.getElementById("navmenu");

		console.log(navmenu.classList);

		if( navmenu.classList.contains("open") ) {
			navmenu.classList.remove("open");
		} else {
			navmenu.classList.add("open");
		}
	});
}

// Opening modal component
var modal_toggler_btn = document.getElementById("demo-modal");
if (modal_toggler_btn != null) {
	modal_toggler_btn.addEventListener("click", function(e) {
		var target = document.getElementById(this.dataset.target);

		if(target.classList.contains("open")) {
			target.classList.remove("open");
		} else {
			target.classList.add("open");
		}
	});
}

// Closing modal component / other component that requires close on click
var close_comp = document.getElementsByClassName("close");
for (var i = close_comp.length - 1; i >= 0; i--) {
	close_comp[i].addEventListener("click", function(e) {
		var target = document.getElementById(e.target.dataset.parent);

		if(target.classList.contains("open")) {
			target.classList.remove("open");
		} else {
			target.classList.add("open");
		}
	});
}


// Opening alert component
var alert_toggler_btn = document.getElementById("demo-alert");
if (alert_toggler_btn != null) {
	alert_toggler_btn.addEventListener("click", function(e) {
		var target = document.getElementById(e.target.dataset.target);

		if(target.classList.contains("open")) {
			target.classList.remove("open");
		} else {
			target.classList.add("open");
		}
	});

}


/**
 * -----------------------------------
 * SLIDERS SCRIPTS
 * -----------------------------------
 * 1. Multiple Horizontal slide show
 * 2. Multiple Vertical slide show
 */
// 1. NEW MULTIPLE SLIDER CODE BY SKM
function slide_show() {
	var slide_width = slider.children[0].clientWidth;
	if(slideIndex > slides - wrapFrom) {
		slideIndex = 0;
		slider.style.transform = "translateX("+ (slideIndex) +"px)";
	} else {
		slider.style.transform = "translateX("+ ((slideIndex * slide_width) * -1) +"px)";
		slideIndex++;
	}

	setTimeout(slide_show, 3000);
}

var slider = document.getElementsByClassName("slider-multi-slides");
slider = slider[0];
if(slider != null) {
	var slides = slider.childElementCount,
		slideIndex = 0,
		// NEED TO BE CHANGED
		// FOR Device width greater than > 480px to 3 and for small device 1
		screenWidth = window.screen.width;
		if( screenWidth > 480)
			wrapFrom = 3;
		else
			wrapFrom = 1;
	// console.log(slider);
	// console.log(slider.children[0].childElementCount);
	slide_show();
}

// 2. NEW MULTIPLE VERTICIAL SLIDER CODE BY SKM

function slide_show_v(wrapFrom) {
	var container_height = document.getElementsByClassName('slider-multi-container slide-up'),
		slide_height = slider_v.children[0].clientHeight;
	container_height = container_height[0].clientHeight;
	var topbottompadding = container_height - slide_height,
		paddingtoberm = topbottompadding / 2,
		translate_height = slide_height + paddingtoberm;

	if(slideIndex_v > slides_v - wrapFrom) {
		slideIndex_v = 0;
		slider_v.style.transform = "translateY("+ (slideIndex_v) +"px)";
	} else {
		slider_v.style.transform = "translateY("+ ((slideIndex_v * translate_height) * -1) +"px)";
		slideIndex_v++;
	}

	setTimeout(function() {
		slide_show_v(wrapFrom);
	}, 3000);
}

var slider_v = document.getElementsByClassName("slider-multi-slides slide-up");
slider_v = slider_v[0];
if(slider_v != null) {
	var slides_v = slider_v.childElementCount,
		slideIndex_v = 0,
		// NEED TO BE CHANGED
		// FOR Device width greater than > 480px to 3 and for small device 1
		screenWidth_v = window.screen.width;
		if( screenWidth_v > 480)
			wrapFrom_v = 1;
		else
			wrapFrom_v = 1;
	// console.log(slider_v);
	// console.log(slider_v.children[0].childElementCount);
	slide_show_v(wrapFrom_v);
}

(function(){
	const accordianButtons = document.querySelectorAll(".accordian-button");
	accordianButtons.forEach((button) => {
		button.addEventListener("click", function(e) {
			const accordian = this.parentElement;
			accordian.classList.toggle("active");
		});
	});
})();