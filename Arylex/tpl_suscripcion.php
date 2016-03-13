<?php
/**
 * @template name: Suscripcion 
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<?php
 	// A continuación podemos ver los valores
	// de acceso a nuestra cuenta a través del API
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
		//Añadimos contacto nuevo 
		$arr_group = array();
		$postData = array(
			'function' => 'addSubscriber',
			'apiKey' => $apiKey,
			'email' => 'pmcruzm@gmail.com',
			'name' => 'Pedro',
			'groups' => array(2)
		);
		
		$post = http_build_query($postData);
		 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		
		$json = curl_exec($curl);
		$result = json_decode($json);
		 
		if ($result->status == 0) {
			throw new Exception('Bad status returned. Something went wrong.');
		}else{
			echo 'Correo integrado perfectamente!!!';
		}
	}
	/*$curl = curl_init('https://pedroxmujica.ip-zone.com/ccm/admin/api/version/2/&type=json');
	 
	/*$postData = array(
		'function' => 'addSubscriber',
		'apiKey' => 'apiKey',
		'email' => 'user@example.org',
		'name' => 'My name',
		'groups' => array(
			1,
			3,
			5
		)
	);
	 
	$post = http_build_query($postData);
	 
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	 
	$json = curl_exec($curl);
	$result = json_decode($json);
	print_r($json); 
	if ($result->status == 0) {
		
		//throw new Exception('Bad status returned. Something went wrong.');
	}
	 
	//var_dump($result->data);*/
	?>
<?php get_footer(); ?>