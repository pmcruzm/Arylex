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
var ajaxurl;
var send_form=0;

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
	
	//Cuando enviamos email a Mailchim 
	jQuery(document).on("submit","#form-bulletin", function(e) {
		e.preventDefault();
		//Obtenemos datos del form
		var email= jQuery('#form-bulletin #email').val();
		var language= jQuery('#form-bulletin #language').val();
		
		jQuery.ajax({
					type: 'POST',
					dataType: 'html',
					url: ajaxurl,
					data: { 
						'action': 'send_mailchimp', 
						'email': email,
						'lang' : language
						},
					success: function(data){
						alert(data);
					}
				});
	});
	
	// Realizar login vía AJAX
    jQuery(document).on('submit', '#form-login', function(e) {
		e.preventDefault();
        
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: { 
                'action': 'ajax_login', //calls wp_ajax_nopriv_ajaxlogin
                'username': jQuery('#form-login #username').val(), 
                'password': jQuery('#form-login #password').val(), 
                'security': jQuery('#form-login #security').val() },
            success: function(data){
				console.log(data);
               if (data.loggedin == true){
					jQuery('#form-login #username').val('');	
					jQuery('#form-login #password').val('')	
					alert(data.message);
				    window.location = data.url;
                }else{
					jQuery('#form-login #username').val('');	
					jQuery('#form-login #password').val('')	
					alert(data.message);
				}
            }
        });
    });
	
	//Eliminar marco de error cuando se hace click sobre un input con error
	jQuery(document).on('focus','form input,form textarea,form input[type=checkbox],form input[type=radio]',function(event){
		event.preventDefault();
		if(jQuery(this).attr('type')!='submit'){
			if(jQuery(this).attr('type')=='radio'){
				if(jQuery('form input[type=radio]').hasClass('error')){
					jQuery('form input[type=radio]').removeClass('error');
				}
			}else{
				if(jQuery(this).hasClass('error')){
					jQuery(this).removeClass('error');
				}
			}
		}
	});
	
	//Enviar formulario de contacto
	jQuery(document).on("submit","#form-contact", function(e) {
		e.preventDefault();
		if(send_form==0){
			send_form=1;
			//Limpiamos errores si no es la primera vez
			jQuery(".errores").html("");
			//Llamamos a la función para validar
			var result=validate_form('#form-contact');
			if(result==1){
				send_form=0;
			}else{
				send_form=0;
				//Enviamos datos para email vía AJAX
				jQuery.ajax({
					type: 'POST',
					dataType: 'html',
					url: ajaxurl,
					data: { 
						'action': 'ajax_contact', //calls wp_ajax_nopriv_ajaxlogin
						'name': jQuery('#form-contact #name').val(), 
						'email': jQuery('#form-contact #email').val(), 
						'telephone': jQuery('#form-contact #telephone').val(),
						'subject': jQuery('#form-contact #subjet').val(),
						'question': jQuery('#form-contact #question').val(),
						'destinatario': jQuery('#form-contact #subjet option:selected').attr('data-mail'),},
					success: function(data){
						//console.log(data);
						if(data=='OK'){
							clean_contacto();
							alert('Formulario enviado correctamente');
						}else{
							alert('Error al enviar el formulario');
						}	
					}
				});
				
			}
		}
	});
	
	// Registration user vía AJAX
    jQuery(document).on('submit', '#form-registration', function(e) {
		e.preventDefault();
        
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: { 
                'action': 'ajax_registration', //calls wp_ajax_nopriv_ajaxlogin
                'password': jQuery('#form-registration #password').val(), 
                'rep_password': jQuery('#form-registration #rep_password').val(), 
                'user': jQuery('#form-registration #user').val() },
            success: function(data){
				console.log(data);
				if (data.register == true){
					jQuery('#form-registration #password').val('');	
					jQuery('#form-registration #rep_password').val('')	
					alert(data.message);
				    window.location = data.url;
                }else{
					jQuery('#form-registration #password').val('');	
					jQuery('#form-registration #rep_password').val('')	
					alert(data.message);
				}
            }
        });
    });
	 
	
});


/*************************
FUNCIONES JAVASCRIPT
**************************/

function clean_contacto(){

jQuery('#form-contact #name').val('');
jQuery('#form-contact #email').val('');
jQuery('#form-contact #rep_email').val('');
jQuery('#form-contact #telephone').val('');
jQuery('#form-contact #subjet').val('-1');
jQuery('#form-contact #question').val('');
jQuery('#form-contact #bbll').prop( "checked", false );

}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

//Funcion para validar genéricamente un formulario
function validate_form(id){

		//Busca todos los campos requeridos de texto
			if(jQuery(id).find('.validation-rule-empty').length > 0){
				var error_empty=0;
				jQuery(id).find('.validation-rule-empty').each(function() {
					if(jQuery(this).is(":visible")){
					var res_campo=jQuery(this).val();
						if(res_campo==""){
							error_empty=1;
								jQuery(this).addClass('error').val('');
						}
					}

				});
			}

			//Busca todos los campos requeridos de mail
			if(jQuery(id).find('.validation-rule-mail').length > 0){
				var error_mail=0;
				jQuery(id).find('.validation-rule-mail').each(function() {
					if(jQuery(this).is(":visible")){
						var res_campo=jQuery(this).val();
						if((res_campo=="") || (res_campo!="" && validateEmail(res_campo)==false) ){
							error_mail=1;
								jQuery(this).addClass('error').val('');
						}
					}

				});
			}
			
			//Busca todos los campos requeridos de telefono
			if(jQuery(id).find('.validation-rule-phone').length > 0){
				var error_phone=0;
				jQuery(id).find('.validation-rule-phone').each(function() {
					if(jQuery(this).is(":visible")){
						var res_campo=jQuery(this).val();
						if((res_campo=="") || (res_campo!="" && isNumber(res_campo)==false) ){
							error_phone=1;
							jQuery(this).addClass('error').val('');
						}
					}

				});
			}


			//Busca todos los campos requeridos de codigo postal{cambiar para email}
			if(jQuery(id).find('.validation-rule-email-rep').length > 0){
				var error_emails=0;
				//Comprobamos que uno de los 2 no está vacío
				if(jQuery('#email').val()!="" && jQuery('#rep_email').val()!=""){
					var email_ini=jQuery('#email').val();
					var email_rept=jQuery('#rep_email').val();
					if(email_ini!=email_rept){
						error_emails=1;
						jQuery('#email').addClass('error').val('');
						jQuery('#rep_email').addClass('error').val('');
					}else{
						if(validateEmail(email_ini)==false || validateEmail(email_rept)==false){
							error_emails=1;
							jQuery('#email').addClass('error').val('');
							jQuery('#rep_email').addClass('error').val('');
						}
					}
				}else{
					error_emails=1;
					jQuery('#email').addClass('error').val('');
					jQuery('#rep_email').addClass('error').val('');
				}
			}

			//Busca todos los campos requeridos checkbox
			if(jQuery(id).find('.validation-rule-checkbox').length > 0){
				var error_checkbox=0;
				jQuery(id).find('.validation-rule-checkbox').each(function() {
					if(!jQuery(this).prop("checked")){
						error_checkbox=1;
						jQuery(this).addClass('error');
					}

				});
			}
			
			//Validación de subject
			if(jQuery(id).find('.validation-rule-select').length > 0){
				var error_select=0;
				jQuery(id).find('.validation-rule-select').each(function() {
					if(jQuery(this).val()==-1){
						error_select=1;
						jQuery(this).addClass('error');
					}
				});
			}

			if(error_empty==1){
				var message=jQuery(id).attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}

			if(error_checkbox==1){
				var message=jQuery(id).find('.validation-rule-checkbox').attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}
			
			if(error_select==1){
				var message=jQuery(id).find('.validation-rule-select').attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}

			if(error_emails==1){
				var message=jQuery(id).find('.validation-rule-email-rep').attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}

			if(error_mail==1){
				var message=jQuery(id).find('.validation-rule-mail').attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}
			
			if(error_phone==1){
				var message=jQuery(id).find('.validation-rule-phone').attr('data-error-msg');
				jQuery('.errores').append('<p>'+message+'</p>');
			}

			//Salida
			if(error_empty==1 || error_checkbox==1 || error_mail==1 || error_select==1 || error_phone==1 || error_emails==1){
				return 1;
			}else{
				return 0;
			}
}