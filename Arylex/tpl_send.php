<?php
/**
 * @template name: Send Mail
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
<?php
//Mail origen 
$email_from='info@arylex.eu';

// Destinatarios
$para  = 'pmcruzm@gmail.com';

// título
$título = 'Recordatorio de cumpleaños para Agosto';

// mensaje
$mensaje = '
<html>
<head>
  <title>Recordatorio de cumpleaños para Agosto</title>
</head>
<body>
  <p>¡Estos son los cumpleaños para Agosto!</p>
  <table>
    <tr>
      <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
    </tr>
    <tr>
      <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: Pedro <pmcruzm@gmail.com>' . "\r\n";
$cabeceras .= 'From: Info Arylex <info@arylex.eu>' . "\r\n";

// Enviarlo
ini_set("sendmail_from", $email_from);
$sent = mail($para, $título, $mensaje, $cabeceras, "-f" .$email_from);
if ($sent)
{
echo "Mensaje enviado OK.";
} else {
echo "There has been an error sending your comments. Please try later.";
}
?>
<?php get_footer(); ?>