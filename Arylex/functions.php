<?php
//Library Mailchimp
require_once 'inc/MCAPI.class.php';

//Libreria PHPMailer
require 'include/PHPMailerAutoload.php';

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

//Custom image sizes
add_image_size( 'list-news', 334, 188, array( 'center', 'center' ) );
add_image_size( 'cover-news', 1024, 367, array( 'center', 'center' ) );

//Roles nuevos  
$result = add_role(
    'new_user_init',
    __( 'New User Init' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    )
);

$result = add_role(
    'new_user_active',
    __( 'New User Active' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    )
);

/*** Top navigation ***/

function register_menu() {
    register_nav_menu('Main_Menu', __('Main_Menu'));
}
add_action( 'init', 'register_menu' );

if ( !is_nav_menu('Main_Menu')) {
    $menu_id = wp_create_nav_menu('Main_Menu');
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
	//wp_register_script( 'arylex-application', get_template_directory_uri() . '/js/application.js', array(), '1.0', 0 );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0', 0 );
	wp_register_script( 'bootstrap-select', get_template_directory_uri() . '/js/bootstrap-select.min.js', array(), '1.0', 0 );
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array(), '1.0', 0 );

	wp_enqueue_script('jquery');
	//wp_enqueue_script( 'arylex-application' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'bootstrap-select' );
	wp_enqueue_script( 'main' );
}


/**
 * Register general styles
 */
function register_css() {
	global $wp_styles;
	
	//wp_register_style( 'style-css', get_template_directory_uri() . '/css/style.css', array(), '1.0' );
	wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap-select.min.css', array(), '1.0' );
	wp_register_style( 'main-css', get_template_directory_uri() . '/css/main.css', array(), '1.0' );
			
	//wp_enqueue_style( 'style-css' );
	wp_enqueue_style( 'bootstrap-css' );
	wp_enqueue_style( 'main-css' );
}

add_action( 'wp_enqueue_scripts', 'register_css' );

/***
* Enviar petición a Mailchimp 
***/

// para peticiones de usuarios que no están logueados
add_action('wp_ajax_nopriv_send_mailrelay', 'send_mailrelay');
// probablemente también vas a querer que los usuarios logueados puedan hacer lo mismo
add_action('wp_ajax_send_mailrelay', 'send_mailrelay');

function send_mailrelay(){
	
		//Añadimos contacto nuevo Mailrelay
		$username = 'arylex';
		$password = '85eae51b';
		$hostname = 'arylex.ip-zone.com';
		
		// El primer paso será validarnos contra el API
		$curl = curl_init('http://' . $hostname . '/ccm/admin/api/version/2/&type=json');
		
		$params = array(
		'function' => 'doAuthentication',
		'username' => $username,
		'password' => $password
		);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		
		// Ejecutaremos la página, lo que nos devolverá un resultado en formato Json
		$result = curl_exec($curl);
		
		$jsonResult = json_decode($result);
		
		if (!$jsonResult->status) {
			echo json_encode(array('error'=>1));
			print_r($jsonResult);
		} else {
			$apiKey = $jsonResult->data;	
			unset($arr_group);
			$arr_group = array();
			switch($_POST["lang"]){
				case 'en':
					$arr_group[]=2;
				break;
				case 'fr':
					$arr_group[]=3;
				break;
				case 'de':
					$arr_group[]=4;
				break;
			}
			$postData = array(
				'function' => 'addSubscriber',
				'apiKey' => $apiKey,
				'email' => $_POST["email"],
				'name' => '',
				'groups' => $arr_group
			);
			
			$post = http_build_query($postData);
			 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
			
			$json = curl_exec($curl);
			$result = json_decode($json);
			//print_r($result);
			 
			if ($result->status == 0) {
				echo json_encode(array('error'=>2));
			}else{
				echo json_encode(array('error'=>0));
			}
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
	
	ob_start();
	require( 'mailing/contact_mailing.php');
	$mensaje = ob_get_contents();
	ob_end_clean();
	$mensaje = str_replace('%nombre%', $_POST['name'], $mensaje); 
	$mensaje = str_replace('%email%', $_POST['email'], $mensaje); 
	$mensaje = str_replace('%telefono%', $_POST['telephone'], $mensaje);
	$mensaje = str_replace('%asunto%', $_POST['question'], $mensaje);
    
	switch($_POST["lang"]){
		case 'en':
			$mail_dest='DowAgroSciencesUK@dow.com';
		break;
		case 'fr':
			$mail_dest='bdattin@dow.com';
		break;
		case 'de':
			$mail_dest='dowagrosciencesd@dow.com';
		break;
	}
	
	//Mail origen 
	$email_from='contact@arylex.eu';
	// título
	$titulo = __('Contact Arylex', 'arylex');
	
	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Cabeceras adicionales
	//$cabeceras .= 'To: Pedro <pmcruzm@gmail.com>' . "\r\n";
	$cabeceras .= 'From: Contact Arylex <contact@arylex.eu>' . "\r\n";
	
	// Enviarlo
	ini_set("sendmail_from", $email_from);
	$sent = mail($mail_dest, $titulo, $mensaje, $cabeceras, "-f" .$email_from);
	if ($sent)
	{
		echo json_encode(array('error'=>0));
	} else {
		echo json_encode(array('error'=>1));
	}
				
	/*$message = file_get_contents('http://citizenzchallenge.cambridge.es/inicio/mailing/mailing_contacto.php'); 
	$message = str_replace('%nombre%', $_POST['nombre'], $message); 
	$message = str_replace('%email%', $_POST['email'], $message); 
	$message = str_replace('%provincia%', $_POST['provincia'], $message); 
	$message = str_replace('%centro%', $_POST['centro'], $message); 
	$message = str_replace('%asunto%', $_POST['asunto'], $message); */
	
	//Enviamos el mail al usuario
	/*$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); // telling the class to use SMTP				
							
	try {
		$mail->Host       = "smtp.livemail.co.uk"; // SMTP server
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->CharSet = 'UTF-8';
		$mail->Host       = "smtp.livemail.co.uk"; // sets the SMTP server
		$mail->Port       = 465;
		$mail->Username   = "info@arylex.eu"; // SMTP account username
		$mail->Password   = "Arylex2016";        // SMTP account password
		$mail->AddReplyTo('info@arylex.eu', __('Mensaje contacto Arylex'));//Dirección de replica del mensaje
		$mail->AddAddress($mail_dest);//Dirección del mensaje
		$mail->SetFrom('info@arylex.eu', __('Mensaje contacto Arylex'));
		// $mail->AddReplyTo('name@yourdomain.com', 'First Last');
		$mail->Subject = __('Mensaje contacto Arylex');
		//$mail->AltBody = $mensaje; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML($mensaje);
		$mail->Send();
		} catch (phpmailerException $e) {
			echo json_encode(array('error'=>1));
		} catch (Exception $e) {
			echo json_encode(array('error'=>1));
		}*/
	
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
                    <option value="en" <?php if ($language_user=='en'){ echo 'selected="selected"';}?>>en</option>
                    <option value="fr" <?php if ($language_user=='fr'){ echo 'selected="selected"';}?>>fr</option>
                    <option value="de" <?php if ($language_user=='de'){ echo 'selected="selected"';}?>>de</option>		
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
	if($_POST['password']!="" && $_POST['rep_password']!=""){
		if($_POST['password']==$_POST['rep_password']){
			if(strlen($_POST['password'])<13 && strlen($_POST['rep_password'])<13){	
				//Obtener el id de usuario
				$info_user=get_user_by( 'login',$_POST['user']);
				$language_user = esc_attr(get_the_author_meta('language_user',$info_user->ID));
				if(!empty( $info_user->roles) && $info_user->roles[0]=='new_user_init'){
					//Actualizamos password 
					wp_set_password($_POST['password'], $info_user->ID);
					//Actualizamos el rol del usuario
					$user_id=wp_update_user( array( 'ID' => $info_user->ID, 'role' =>'new_user_active' ) );
					if ( is_wp_error( $user_id ) ) {
						echo json_encode(array('register'=>false, 'message'=>__('Error updating role.'),'url'=>''));
					}else{	
						//Añadimos contacto nuevo Mailrelay
						$username = 'arylex';
						$password = '85eae51b';
						$hostname = 'arylex.ip-zone.com';
						
						// El primer paso será validarnos contra el API
						$curl = curl_init('http://' . $hostname . '/ccm/admin/api/version/2/&type=json');
						
						$params = array(
						'function' => 'doAuthentication',
						'username' => $username,
						'password' => $password
						);
						
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
						
						// Ejecutaremos la página, lo que nos devolverá un resultado en formato Json
						$result = curl_exec($curl);
						
						$jsonResult = json_decode($result);
						
						if (!$jsonResult->status) {
							echo json_encode(array('register'=>false, 'message'=>__('Failed to connect to Mailrelay'),'url'=>''));
						} else {
							$apiKey = $jsonResult->data;	
							unset($arr_group);
							$arr_group = array();
							switch($language_user){
								case 'en':
									$arr_group[]=2;
								break;
								case 'fr':
									$arr_group[]=3;
								break;
								case 'de':
									$arr_group[]=4;
								break;
							}
							$postData = array(
								'function' => 'addSubscriber',
								'apiKey' => $apiKey,
								'email' => $info_user->user_email,
								'name' => '',
								'groups' => $arr_group
							);
							
							$post = http_build_query($postData);
							 
							curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
							
							$json = curl_exec($curl);
							$result = json_decode($json);
							 
							if ($result->status == 0) {
								echo json_encode(array('register'=>false, 'message'=>__('Problem subscribe email in Mailrelay'),'url'=>''));
							}else{
								echo json_encode(array('register'=>true, 'message'=>__('Success!'),'url'=>get_home_url()));
							}
						}
					}
						
				}else{
					echo json_encode(array('register'=>false, 'message'=>__('Unable to update password, please contact the administrator.'),'url'=>''));
				}
			}else{
				echo json_encode(array('register'=>false, 'message'=>__('Wrong password length.'),'url'=>''));
			}
		}else{
			echo json_encode(array('register'=>false, 'message'=>__("The two passwords you entered don't match."),'url'=>''));
		}
	}else{
		echo json_encode(array('register'=>false, 'message'=>__("Sorry, we don't accept empty passwords."),'url'=>''));
	}
	
    die();
}

/***
* Archivos de traduccion  
***/

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
	//Asignar traducciones del theme 
	load_theme_textdomain( 'arylex', get_template_directory().'/languages' ); 
}

/***
* Excluir páginas de login de la búsqueda búsqueda  
***/
function fb_search_filter($query) {
if ( !$query->is_admin && $query->is_search) {
	$query->set('post__not_in', array('249','250','247','236','31','650','652','654','656','510','655','651','653','657','511'));
}
return $query;
}
add_filter( 'pre_get_posts', 'fb_search_filter' );

/***
* Custom Forget password  
***/

// Change Subject
add_filter( 'retrieve_password_title', function( $title, $user_login, $user_data ) {
	return __( 'Password Recovery' );
}, 10, 3 );
// Change email type to HTML
add_filter( 'wp_mail_content_type', function( $content_type ) {
	return 'text/html';
});
// Change the message/body of the email
add_filter( 'retrieve_password_message', 'rv_new_retrieve_password_message', 10, 4 );
function rv_new_retrieve_password_message( $message, $key, $user_login, $user_data ){
	
	$language_user = esc_attr(get_the_author_meta('language_user',$user_data->ID));
	
	$reset_url = add_query_arg( array(
		'action' => 'rp',
		'key' => $key,
		'login' => rawurlencode( $user_login ),
		'lang' => $language_user
	), wp_login_url() );
	ob_start();
	
	printf( '<p>%s</p>', __( 'Hi, ' ) . get_user_meta( $user_data->ID, 'first_name', true ) );
	printf( '<p>%s</p>', __( 'It looks like you need to reset your password on the site. If this is correct, simply click the link below. If you were not the one responsible for this request, ignore this email and nothing will happen.' ) );
	printf( '<p><a href="%s">%s</a></p>', $reset_url, __( 'Reset Your Password' ) );
	
	$message = ob_get_clean();
	return $message;
}


/***
* Shortcode Custom login 
***/

?>