<?php
include('m2brimagem.class.php');

$arquivo	= $_GET['arquivo'];
$largura	= $_GET['largura'];
$altura		= $_GET['altura'];
$pb			= ($_GET['pb'] == 1) ? 1 : 0;

$oImg = new m2brimagem($arquivo);
$valida = $oImg->valida();
if ($valida == 'OK') {
	$oImg->rgb( 255, 255, 255 );
	$oImg->redimensiona($largura,$altura,'crop');
    if($pb) $oImg->grava(1); else $oImg->grava();
} else {
	die($valida);
}
exit;
?>
