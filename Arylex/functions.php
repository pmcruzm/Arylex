<?php
//Library Mailchimp
require_once 'inc/MCAPI.class.php';
//Libreria PHPMailer
require 'include/PHPMailerAutoload.php';

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

//Asignar traducciones del theme 
load_theme_textdomain( 'arylex', get_template_directory().'/languages' ); 

/*** Top navigation ***/

function register_menu() {
    register_nav_menu('Main_Menu', __('Main_Menu'));
}
add_action( 'init', 'register_menu' );

if ( !is_nav_menu('Header')) {
    $menu_id = wp_create_nav_menu('Header');
    wp_update_nav_menu_item($menu_id, 1);
}

//Añadir Excerpt para post y pages 
add_post_type_support('page', 'excerpt');

//add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-thumbnails' );


remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Register general scripts
*/

add_action( 'wp_enqueue_scripts', 'register_js' );
function register_js() {
	wp_register_script( 'arylex-application', get_template_directory_uri() . '/js/application.js', array(), '1.0', 0 );
	/*wp_register_script( 'crazydiamond-scrollTo', LOLLUM_URI . '/js/jquery.scrollTo.min.js', array(), '1.0', 0 );
	wp_register_script( 'crazydiamond-fancybox', LOLLUM_URI . '/js/jquery.fancybox.js', array(), '1.0', 0 );
	wp_register_script( 'crazydiamond-modernizr', LOLLUM_URI . '/js/modernizr.js', array(), '1.0', 0 );
	wp_register_script( 'crazydiamond-common', LOLLUM_URI . '/js/common.js', array( 'jquery' ), '1.0', 1 );*/

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'arylex-application' );
	/*wp_enqueue_script( 'crazydiamond-scrollTo' );
	wp_enqueue_script( 'crazydiamond-fancybox' );
	wp_enqueue_script( 'crazydiamond-modernizr' );*/
}

/**
 * Register general styles
 */
function register_css() {
	global $wp_styles;
	
	wp_register_style( 'style-css', get_template_directory_uri() . '/css/style.css', array(), '1.0' );
	//wp_register_style( 'grid-css', get_template_directory_uri() . '/css/grid.css', array(), '1.0' );
	//wp_register_style( 'crazydiamond-fonts', get_template_directory_uri() . '/css/fonts.css', array(), '1.0' );
	//wp_register_style( 'crazydiamond-default', get_stylesheet_uri(), '1.0' );
	//wp_register_style( 'crazydiamond-css', get_template_directory_uri() . '/css/base.css', array(), '1.0' );
			
	wp_enqueue_style( 'style-css' );
	//wp_enqueue_style( 'grid-css' );

	//wp_enqueue_style( 'ie8-css' );
	//$wp_styles->add_data( 'ie8-css', 'conditional', 'lt IE 9' );
}

add_action( 'wp_enqueue_scripts', 'register_css' );

/***
* Enviar petición a Mailchimp 
***/

// para peticiones de usuarios que no están logueados
add_action('wp_ajax_nopriv_send_mailchimp', 'send_mailchimp');
// probablemente también vas a querer que los usuarios logueados puedan hacer lo mismo
add_action('wp_ajax_send_mailchimp', 'send_mailchimp');

function send_mailchimp(){
	
	//echo $_POST['email'].'--'.$_POST['lang'];
	
		$api = new MCAPI('143754790e3a7210e0b817b06491194b-us8');
		$merge_vars = array('MC_LANGUAGE'=>$_POST["lang"]);
		 
		// Submit subscriber data to MailChimp
		// For parameters doc, refer to: http://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php
		$retval = $api->listSubscribe( '178e1a7379', $_POST["email"], $merge_vars, 'html', false, true );
		 
		if ($api->errorCode){
			echo "Please try again.";
		} else {
			echo "Thank you, you have been added to our mailing list.";
		}
	exit;
}

/***
* Login WP vía formulario  
***/

// para peticiones de usuarios que no están logueados
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');
// probablemente también vas a querer que los usuarios logueados puedan hacer lo mismo
add_action('wp_ajax_ajax_login', 'ajax_login');

function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
	wp_set_current_user($user->ID); //Here is where we update the global user variables
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.'),'url'=>''));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...'),'url'=>get_home_url()));
    }
	
    die();
}

/***
* Enviar formulario de contacto  
***/

// para peticiones de usuarios que no están logueados
add_action('wp_ajax_nopriv_ajax_contact', 'ajax_contact');
// probablemente también vas a querer que los usuarios logueados puedan hacer lo mismo
add_action('wp_ajax_ajax_contact', 'ajax_contact');

function ajax_contact(){
    
	$mensaje='Name: '.$_POST['name'].'<br/>Email: '.$_POST['email'].'<br/>Telephone: '.$_POST['telephone'].'<br/>Subject: '.$_POST['subject'].'<br/>Question: '.$_POST['question'].'<br/>Destinatario: '.$_POST['destinatario'];
	
	//Enviamos el mail al usuario
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); // telling the class to use SMTP
				
	/*$message = file_get_contents('http://citizenzchallenge.cambridge.es/inicio/mailing/mailing_contacto.php'); 
	$message = str_replace('%nombre%', $_POST['nombre'], $message); 
	$message = str_replace('%email%', $_POST['email'], $message); 
	$message = str_replace('%provincia%', $_POST['provincia'], $message); 
	$message = str_replace('%centro%', $_POST['centro'], $message); 
	$message = str_replace('%asunto%', $_POST['asunto'], $message); */
				
							
	try {
		$mail->Host       = "localhost"; // SMTP server
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->CharSet = 'UTF-8';
		$mail->Host       = "localhost"; // sets the SMTP server
		$mail->Username   = "citizen@pedroxmujica.com"; // SMTP account username
		$mail->Password   = "pedrom8";        // SMTP account password
		$mail->AddReplyTo('citizen@pedroxmujica.com', 'Mensaje contacto Arylex');//Dirección de replica del mensaje
		$mail->AddAddress($_POST['destinatario']);//Dirección del mensaje
		$mail->SetFrom('citizen@pedroxmujica.com', 'Mensaje contacto Arylex');
		// $mail->AddReplyTo('name@yourdomain.com', 'First Last');
		$mail->Subject = 'Mensaje contacto Arylex';
		//$mail->AltBody = $mensaje; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML($mensaje);
		$mail->Send();
		} catch (phpmailerException $e) {
			echo "KO";
		} catch (Exception $e) {
			echo "KO";
		}
			echo 'OK';
	
    die();
}
/***
* Extra input user registration   
***/

function custom_user_profile_fields($user){
    if(is_object($user))
        $language_user = esc_attr( get_the_author_meta( 'language_user', $user->ID ) );
    else
        $language_user = null;
    ?>
    <h3>Language profile</h3>
    <table class="form-table">
        <tr>
            <th><label for="language_user">User language</label></th>
            <td>
            	<select id="language_user" name="language_user">
                    <option value="en" <?php if ($language_user=='EN'){ echo 'selected="selected"';}?>>en</option>
                    <option value="fr" <?php if ($language_user=='FR'){ echo 'selected="selected"';}?>>fr</option>
                    <option value="de" <?php if ($language_user=='DE'){ echo 'selected="selected"';}?>>de</option>		
                </select>
            </td>
        </tr>
    </table>
<?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
    # again do this only if you can
    if(!current_user_can('manage_options'))
        return false;
 
    # save my custom field
    update_user_meta($user_id, 'language_user', $_POST['language_user']);
}
add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

/***
* Registration WP vía formulario  
***/

// para peticiones de usuarios que no están logueados
add_action('wp_ajax_nopriv_ajax_registration', 'ajax_registration');
// probablemente también vas a querer que los usuarios logueados puedan hacer lo mismo
add_action('wp_ajax_ajax_registration', 'ajax_registration');

function ajax_registration(){
	
	if($_POST['password']==$_POST['rep_password']){
		//Obtener el id de usuario
		$info_user=get_user_by( 'email',$_POST['password']);
		print_r($info_user);
		//$user_id=$_POST['hash'];//Pasar a string 
		//wp_set_password($_POST['password'], $user_id );
		//echo 'OK';
	}else{
		echo 'Password no coincide';
	}
	
    die();
}


/***
* Enviar formulario después de alta de usuario  
***/

add_action( 'user_register', 'send_user_data', 10, 1 );

function send_user_data( $user_id ) {

   // if ( isset( $_POST['first_name'] ) )
   //     update_user_meta($user_id, 'first_name', $_POST['first_name']);
   
   //Obtener variable language 
   $language_user = esc_attr(get_the_author_meta('language_user',$user_id));
   
   $mensaje='Hola '.$_POST['first_name'].',<br/> Recuerda que tu usuario es -'.$_POST['user_login'].'- y para poder activar tu cuenta debes introducir tu password a través del siguiente enlace <a href="http://pedroxmujica.com/Arylex/user-registration/?mail='.$_POST['user_email'].'">Pincha aquí</a>.<br/>Idioma del usuario: '.$language_user;
	
	//Enviamos el mail al usuario
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); // telling the class to use SMTP
				
							
	try {
		$mail->Host       = "localhost"; // SMTP server
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->CharSet = 'UTF-8';
		$mail->Host       = "localhost"; // sets the SMTP server
		$mail->Username   = "citizen@pedroxmujica.com"; // SMTP account username
		$mail->Password   = "pedrom8";        // SMTP account password
		$mail->AddReplyTo('citizen@pedroxmujica.com', 'Usuario nuevo Arylex');//Dirección de replica del mensaje
		$mail->AddAddress($_POST['user_email']);//Dirección del mensaje
		$mail->SetFrom('citizen@pedroxmujica.com', 'Usuario nuevo Arylex');
		// $mail->AddReplyTo('name@yourdomain.com', 'First Last');
		$mail->Subject = 'Usuario nuevo Arylex';
		//$mail->AltBody = $mensaje; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML($mensaje);
		$mail->Send();
		} catch (phpmailerException $e) {
			echo $e;
		} catch (Exception $e) {
			echo $e;
		}
		
		echo 'Mensaje enviado';
		
		die();

}

?>