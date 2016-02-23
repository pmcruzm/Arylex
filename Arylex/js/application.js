/**********************
FUNCIONES JQUERY
Autor:Pedro de la Cruz
Fecha: 22-02-2016
Cliente: Dow Arylex
***********************/


/**********************
VARIABLES
**********************/
 var alm_is_animating = false;

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
	
	
	//Opciones de Key Benefits de la Home 
	jQuery(document).on("click",".box_KB ul li a", function(e) {
		e.preventDefault();
		
		var opc=jQuery(this).attr('rel');
		jQuery(".box_KB ul li a").removeClass('active');
		jQuery(this).addClass('active');
		
		jQuery(".content-KB").removeClass('active');
		jQuery('#'+opc).addClass('active');	
	});
	
	//Cambiar categorias en FAQs
	jQuery(document).on("click","ul.menu-faqs li a", function(e) {
		e.preventDefault();
		
		var opc=jQuery(this).attr('rel');
		console.log(opc);
		var cambio;
		cambio = {taxonomyTerms:opc};  
    
      	alm_is_animating = true;   
		
        var data = cambio, // Get data values from selected menu item
             transition = 'fade', // 'slide' | 'fade' | null
             speed = '300'; //in milliseconds
             
        jQuery.fn.almFilter(transition, speed, data);
	});
	
	jQuery.fn.almFilterComplete = function(){      
      alm_is_animating = false; // clear alm_isanimating flag
    };
	
	/*jQuery.fn.almEmpty = function(alm){
	 jQuery('.alm-listing').html('<h2 class="error_search">No existen materiales para estas opciones de búsqueda</h2>');
	};*/
	
});


/*************************
FUNCIONES JAVASCRIPT
**************************/