<?php
set_time_limit(0);
///header("Content-Type: text/plain");
include "funciones.php";
$url = 'botVisita.php';
$resul = traeProxy();

if($resul['estado'] == "Termino"){
	echo $resul['texto'];

	return false;
}
else if($resul['estado'] == "Ocupado"){
	echo RecargarPagina(0,$url);
	return false;
}

$proxy = trim($resul['proxy']);

if($resul['estado'] == "Error"){
	echo $resul['texto'];

	$tiempo = rand(0,60);
	echo RecargarPagina($tiempo,$url);

	return false;
}



$strViews_ini = '<div class="watch-view-count">';
$strViews_fin = '</div>';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://www.youtube.com/watch?v=zBqyPZ_xnu8");
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_HEADER, 1);


$salida = curl_exec ($ch);
curl_close ($ch);
$visitas = extraeDato($salida,$strViews_ini,$strViews_fin);
echo "proxy a utilizar: ".$proxy;
echo "<br>";
if($visitas == null){
	echo "<br>recargando pagina<br>";
}else{
	echo "visitas: ".$visitas;
}

guardaResultTxt($proxy,$visitas);
echo RecargarPagina(0,$url);
	$errorTime=error_get_last();
	if($errorTime){	
		escribeErrorTxt($errorTime['type'].' - '.$errorTime['message'].' - '.$errorTime['file'].' - '.$errorTime['line']);
	}
	register_shutdown_function('shutdownFunction'); 
	function shutDownFunction() { 
		$error = error_get_last(); 
		if ($error['type'] == 1) { 
			escribeErrorTxt($errorTime['type'].' - '.$errorTime['message'].' - '.$errorTime['file'].' - '.$errorTime['line']);
		} 
	} 
?>