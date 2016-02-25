<?php
//Library Mailchimp
require_once 'inc/MCAPI.class.php';

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links'); 

/*** Top navigation ***/

function register_menu() {
    register_nav_menu('Header', __('Header'));
}
add_action( 'init', 'register_menu' );

if ( !is_nav_menu('Header')) {
    $menu_id = wp_create_nav_menu('Header');
    wp_update_nav_menu_item($menu_id, 1);
}

//Añadir Excerpt para post y pages 
add_post_type_support('page', 'excerpt');

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

//Hacer login vía Ajax de usuario
/*function ajax_login_init(){

    wp_register_script('application', get_template_directory_uri() . '/js/application.js', array('jquery') ); 
    wp_enqueue_script('application');

    wp_localize_script( 'application', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
   // add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
	
	//add_action( 'wp_ajax_nopriv_ajaxloginact', 'ajax_login_act' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}*/

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

?>