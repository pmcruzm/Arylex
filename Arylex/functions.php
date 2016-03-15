<?php
//Library Mailchimp
require_once 'inc/MCAPI.class.php';

//Libreria PHPMailer
require 'include/PHPMailerAutoload.php';

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

//Asignar traducciones del theme 
load_theme_textdomain( 'arylex', get_template_directory().'/languages' ); 

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

	//wp_enqueue_style( 'ie8-css' );
	//$wp_styles->add_data( 'ie8-css', 'conditional', 'lt IE 9' );
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
		$username = 'pedroxmujica';
		$password = 'd166184a';
		$hostname = 'pedroxmujica.ip-zone.com';
		
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
			 
			if ($result->status == 0) {
				echo json_encode(array('error'=>1));
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
    
	$mensaje='Name: '.$_POST['name'].'<br/>Email: '.$_POST['email'].'<br/>Telephone: '.$_POST['telephone'].'<br/>Subject: '.$_POST['subject'].'<br/>Question: '.$_POST['question'].'<br/>Destinatario: '.$_POST['destinatario'];
				
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
	
	if($_POST['password']==$_POST['rep_password']){
		//Obtener el id de usuario
		$info_user=get_user_by( 'login',$_POST['user']);
		$language_user = esc_attr(get_the_author_meta('language_user',$info_user->ID));
		if(!empty( $info_user->roles) && $info_user->roles[0]=='new_user_init'){
			//Actualizamos password 
			wp_set_password($_POST['password'], $info_user->ID);
			//Actualizamos el rol del usuario
			$user_id=wp_update_user( array( 'ID' => $info_user->ID, 'role' =>'new_user_active' ) );
			if ( is_wp_error( $user_id ) ) {
				echo json_encode(array('register'=>false, 'message'=>__('Error al actualizar el rol.'),'url'=>''));
			}else{	
				//Añadimos contacto nuevo Mailrelay
				$username = 'pedroxmujica';
				$password = 'd166184a';
				$hostname = 'pedroxmujica.ip-zone.com';
				
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
					throw new Exception('Fallo en la validación. Verifique su hostname, username o password.');
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
						throw new Exception('Bad status returned. Something went wrong.');
					}else{
						echo "Thank you, you have been added to our mailing list.";
					}
				}
			
				//Inscribimos en lista de mailchimp MailChimp
				/*$api = new MCAPI('143754790e3a7210e0b817b06491194b-us8');
				$merge_vars = array('MC_LANGUAGE'=>$language_user);
				
				$retval = $api->listSubscribe( '178e1a7379', $info_user->user_email, $merge_vars, 'html', false, true );
				 
				if ($api->errorCode){
					 echo json_encode(array('register'=>false, 'message'=>__('Error al añadir a mailchimp.'),'url'=>''));
				} else {
					 echo json_encode(array('register'=>true, 'message'=>__('Registro completado, redirigiendo...'),'url'=>get_home_url()));
				}*/
			}
				
		}else{
			echo json_encode(array('register'=>false, 'message'=>__('No es posible actualizar password, pongase en contacto con el administrador'),'url'=>''));
		}
	}else{
		echo json_encode(array('register'=>false, 'message'=>__('Password y repetición no coinciden.'),'url'=>''));
	}
	
    die();
}


?>