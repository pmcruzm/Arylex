/**********************
FUNCIONES JQUERY
Autor:Pedro de la Cruz
Fecha: 22-02-2016
Cliente: Dow Arylex
***********************/


/**********************
VARIABLES
**********************/


//Eventos para dispositivos móviles
var ua = navigator.userAgent,
event = (ua.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)) ? "touchstart" : "click";
var device='none';
if(ua.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)){
	device='yes';
}

jQuery.noConflict();

jQuery(window).load(function(){

		
});

jQuery(document).ready(function(){
	//Abrir el modal de registro 
	jQuery(document).on("click",".box_KB ul li a", function(e) {
		e.preventDefault();
		
		var opc=jQuery(this).attr('rel');
		jQuery(".box_KB ul li a").removeClass('active');
		jQuery(this).addClass('active');
		
		jQuery(".content-KB").removeClass('active');
		jQuery('#'+opc).addClass('active');
		
	});
	
	
});


/*************************
FUNCIONES JAVASCRIPT
**************************/