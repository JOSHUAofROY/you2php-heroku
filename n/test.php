<?
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

function extraeDato($datoSalida,$cortaIni,$cortaFin){
	$largoTotal = strlen($datoSalida);
	$largoCorta_ini= strpos($datoSalida,$cortaIni);
	$largoCorta_ini = $largoCorta_ini + strlen($cortaIni);
	$cortado = substr($datoSalida, $largoCorta_ini, $largoTotal);
	$largoCorta_fin = strpos($cortado,$cortaFin);
	$cortado = substr($cortado, 0, $largoCorta_fin);
	return $cortado;
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

echo $visitas;
 ?>