<?
function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return addslashes($result);
}

$host = "mysql01.metropolitanbc.hospedagemdesites.ws";
$usuario = "metropolitanbc";
$senha = "c1a99q";
$banco = "metropolitanbc";

$conn = mysql_connect($host, $usuario, $senha) or die (mysql_error());
$db = mysql_select_db($banco, $conn) or die (mysql_error());

$Sql = mysql_query("Insert into formulario (`dtForm`, `ipForm`,`siteForm`,`campoForm`) VALUES (NOW(),'".$_SERVER[REMOTE_ADDR]."','".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."','".array_to_json($_POST)."')") or die(mysql_error());


$nome = utf8_decode($_POST['nome']);
$email = utf8_decode($_POST['email']);
$telefone = utf8_decode($_POST['telefone']);
$assunto = utf8_decode($_POST['assunto']);
$mensagem = utf8_decode($_POST['mensagem']);

//$email2 = "bruno.bacci@maximapromocoes.com.br,alexandre.cardoso@apoenaimoveis.com.br,nelson@apoenaimoveis.com.br,tele@apoenaimoveis.com.br";
require_once('Mail/class.phpmailer.php');

$formato = "\nContent-type: text/html; charset=utf-8\n";
	$msg .= "<h2>CONTATO - Pallazo Royalle</h2>";
	$msg .= "<b>Nome:</b> $nome<br>";
	$msg .= "<b>Email:</b> $email<br>";
	$msg .= "<b>Telefone:</b> $telefone<br>";
	$msg .= "<b>Assunto:</b> $assunto<br>";
	$msg .= "<b>Mensagem:</b> $mensagem";


			$mail = new PHPMailer();
			$mail->SMTPAuth   = true;
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "smtp.pallazoroyalle.com.br"; // SMTP server
			$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)

			$mail->Host       = "smtp.pallazoroyalle.com.br"; // sets the SMTP server
			$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
			$mail->Username   = "contato@caffenes.com.br"; // SMTP account username
			$mail->Password   = "tatcon12";        // SMTP account password
			$mail->SetFrom('contato@caffenes.com.br', 'CONTATO - Pallazo Royalle');
			$mail->AddReplyTo($_POST['email'], $_POST['nome']);
			$mail->Subject    = "CONTATO - Pallazo Royalle";
			$mail->AltBody    = $msg;
			$mail->MsgHTML($msg);
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			
			$mail->AddAddress('contato@caffenes.com.br');
			$mail->AddAddress('financeiro@caffenes.com.br');
			$mail->AddAddress('gerencia@caffenes.com.br');
			$mail->AddAddress('daniel.cembranelli@wpcriativa.com.br');
			
			if(!$mail->Send()) {
			  echo "nao" . $mail->ErrorInfo;
			} else {
			  echo "sim";
			}



?>